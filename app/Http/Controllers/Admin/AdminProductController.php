<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Product;
use App\Model\ProductAttribute;
use App\Model\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Helpers\QRCodeHelper;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index');
    }


    /**
     * Load products data
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function search(Request $request)
    {
       
        if($request->ajax())
        {
            $currentPage = ($request->start == 0) ? 1 : (($request->start / $request->length) + 1);

            Paginator::currentPageResolver(function() use($currentPage){
                return $currentPage;
            });

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $qrCodePath = url(config('constant.QR_CODE_PATH'));
            
            $query = Product::selectRaw('products.id,products.is_active,products.product_id,
            CONCAT("'.$qrCodePath.'","/",IFNULL(qr_code_image,"default-user.png")) as qr_code_image,
            products.product_name,categories.name as category')
            ->leftJoin('categories', 'categories.id', 'products.category_id');
            
            
            $query->where(function($query) use($request){
                $query->orWhere('categories.name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('products.product_name', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $products = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
               
            $products['recordsFiltered'] = $products['recordsTotal'] = $products['total'];

            foreach($products['data'] as $key => $product)
            {
                
                $params = [
                    'product' => $product['id']
                ];

                $deleteRoute = route('products.destroy', $params);
                $viewRoute = route('products.show', $params);
                $editRoute = route('products.edit', $params);
                $statusRoute = route('products.status', $params);
                
                $status = ($product['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                
                
                $products['data'][$key]['qr_code_image'] = '<img src="'.$product['qr_code_image'].'" class="rounded-circle" width="40" height="40">';
                $products['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                $products['data'][$key]['action'] ='<a href="' . $viewRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View product"><i class="zmdi zmdi-eye"></i></a>&nbsp&nbsp';
                $products['data'][$key]['action'] .='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit product"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $products['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="product" data-type="confirm" title="delete product"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($products);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::selectRaw('categories.id,categories.name as category_name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'product_name' => 'required',
            'category_id' => 'required',
            'description' => 'nullable'
        ]); 

        \DB::begintransaction();
        // $isSuccess = QRCodeHelper::generateQrCode('{"table_id":77789897221}', public_path('admin-assets/images/qr_code_image/qr1.png'));
        // dd($isSuccess);
        
        $product = new Product();
        $product->fill($request->all());
        
        if($product->save())
        {
            $product->product_id = $product->id.time().\Str::random(4);
            $product->save();

            $encrypted = base64_encode($product->product_id);

            $qrCodePath = public_path(config('constant.QR_CODE_PATH'));
            
            $fullPath = $qrCodePath.'/qr_prod_'.$product->product_id.'_tab.jpg';
           
            $qrCode = QRCodeHelper::generateQrCode( $encrypted, $fullPath);
            
            $product->qr_code = $qrCode;
            $product->qr_code_image = 'qr_prod_'.$product->product_id.'_tab.jpg';
            $product->save();

            \DB::commit();

            return redirect(route('products.index'))->with('success', trans('messages.products.add.success'));
        }
        return redirect(route('products.index'))->with('error', trans('messages.products.add.error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        
        $qrCodePath = url(config('constant.QR_CODE_PATH'));

        $productDetail = Product::where('products.id', $product->id)
        ->selectRaw('products.id,products.product_id,categories.name as category,
        product_name,description,CONCAT("'.$qrCodePath.'","/",IFNULL(qr_code_image,"default-user.png")) as qr_code_image')
        ->leftJoin('categories', 'categories.id', 'products.category_id')
        ->first();
        return view('admin.products.view', compact('productDetail'));
    }
    
    public function getPrintOutPage()
    {
        $qrCodePath = url(config('constant.QR_CODE_PATH'));

        $qrCodes = Product::selectRaw('product_id,CONCAT("'.$qrCodePath.'","/",IFNULL(qr_code_image,"default-user.png")) as qr_code_image')
        ->get();
        
        return view('admin.products.printout', compact('qrCodes'));
    }

    /**
     * Change user status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(Product $product)
    {
        if (empty($product))
        {
            return redirect(route('products.index'))->with('error', trans('messages.products.not_found_admin'));
        }

        $product->is_active = !$product->is_active;
        
        if ($product->save()) 
        {
            $status = $product->is_active ? 'Active' : 'Inactive';

            return redirect(route('products.index'))->with('success', trans('messages.products.status.success', ['status' => $status]));
        }

        return redirect(route('products.index'))->with('error', trans('messages.products.status.error'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::selectRaw('categories.id,categories.name as category_name')->get();
        $productDetail = $product;

        return view('admin.products.create', compact('categories', 'productDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'product_name' => 'required',
            'category_id' => 'required',
            'description' => 'nullable'
        ]);

        $product = Product::find($id);
        $product->fill($request->all());
        
        if($product->save())
        {
            return redirect(route('products.index'))->with('success', trans('messages.products.update.success'));
        }

        return redirect(route('products.index'))->with('error', trans('messages.products.update.error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {   
        $admin = \Auth::guard('admin')->user();
        
        if(!\Hash::check($request->password, $admin->password))
        {
            return redirect(route('products.index'))->with('error', trans('messages.products.delete.invalid_password'));
        }

        // remove qr code
        $fileNameWithPath = public_path(config('constant.QR_CODE_PATH')).$product->qr_code_image;

        if(file_exists($fileNameWithPath))
        {
            if(is_file($fileNameWithPath))
            {
                unlink($fileNameWithPath);
            }
        }

        if($product->delete())
        {
            return redirect(route('products.index'))->with('success', trans('messages.products.delete.success'));
        }

        return redirect(route('products.index'))->with('error', trans('messages.products.delete.error'));
    }
}
