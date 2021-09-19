<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ModelCustomerProductWishlist;
use App\ModelProduct;
use App\ModelProductAttribute;
use App\ModelProductImage;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

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

            $S3avatar = config('constant.S3_AVATAR');

            $start = ($request->start == 0) ? 1 : (($request->start) * ($request->length) + 1);

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $S3product = config('constant.S3_PRODUCTS');

            $query = Product::selectRaw('products.id,stores.store_name,
            users.name as seller_name,products.is_active,
            (select CONCAT("'.$S3product.'", IFNULL(product_images.image,"default-user.png")) from product_images where product_images.product_id=products.id and product_images.is_active=1 order by product_images.id limit 1) as product_image,
            products.product_name,products.product_name_ar,categories.category')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            ->leftJoin('stores', 'stores.id', 'products.store_id')
            ->leftJoin('users', 'users.id', 'products.seller_id');
            
            $query->where(function($query) use($request){
                $query->orWhere('users.name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('stores.store_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('categories.category', 'like', '%'.$request->search['value'].'%')
                ->orWhere('products.product_name_ar', 'like', '%'.$request->search['value'].'%');
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
                $statusRoute = route('products.status', $params);
                
                $status = ($product['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                
                $products['data'][$key]['product_image'] = '<img src="'.$product['product_image'].'" class="rounded-circle" width="40" height="40">';
                $products['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                $products['data'][$key]['action'] ='<a href="' . $viewRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View product"><i class="zmdi zmdi-eye"></i></a>&nbsp&nbsp';
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $S3product = config('constant.S3_PRODUCTS');

        $productDetail = Product::where('products.id', $product->id)
        ->selectRaw('stores.store_name,
        users.name as seller_name,categories.category,
        products.*')
        ->with(['productImages' => function($query) use($S3product){
            $query->selectRaw('product_images.id,product_images.product_id,
            CONCAT("'.$S3product.'", IFNULL(product_images.image,"default-user.png")) as product_image')
            ->where('product_images.is_active', 1);
        }])
        ->with(['productAttributes' => function($query){
            $query->selectRaw('product_attributes.id,product_attributes.product_id,product_attributes.type,product_attributes.value');
        }])
        ->leftJoin('categories', 'categories.id', 'products.category_id')
        ->leftJoin('stores', 'stores.id', 'products.store_id')
        ->leftJoin('users', 'users.id', 'products.seller_id')
        ->first();


        return view('admin.products.view', compact('productDetail'));
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        CustomerProductWishlist::where('product_id', $product->id)->delete();
        ProductImage::where('product_id', $product->id)->delete();
        ProductAttribute::where('product_id', $product->id)->delete();
        
        if($product->delete())
        {
            return redirect(route('products.index'))->with('success', trans('messages.products.delete.success'));
        }

        return redirect(route('products.index'))->with('error', trans('messages.products.delete.error'));
    }
}
