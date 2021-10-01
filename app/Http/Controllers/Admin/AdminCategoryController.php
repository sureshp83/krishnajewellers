<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use Illuminate\Pagination\Paginator;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index');
    }


    /**
     * Load categories data
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

            $query = Category::selectRaw('categories.id,categories.name');
            
            $query->where(function($query) use($request){
                $query->orWhere('categories.name', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $categories = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $categories['recordsFiltered'] = $categories['recordsTotal'] = $categories['total'];

            foreach($categories['data'] as $key => $category)
            {
                
                $params = [
                    'category' => $category['id']
                ];

                $deleteRoute = route('categories.destroy', $params);
                $editRoute = route('categories.edit', $params);
                
                $categories['data'][$key]['action'] ='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit category"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $categories['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="category" data-type="confirm" title="delete category"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($categories);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->name;
        
        if($category->save())
        {
            return redirect(route('categories.index'))->with('success', trans('messages.categories.add.success'));
        }

        return redirect(route('categories.index'))->with('error', trans('messages.categories.add.error'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categoryDetail = $category;

        return view('admin.category.create', compact('categoryDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Category::find($category->id);
        $category->name = $request->name;

        if ($category->save()) 
        {
            return redirect(route('categories.index'))->with('success', trans('messages.categories.update.success'));
        }

        return redirect(route('categories.index'))->with('error', trans('messages.categories.update.error'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $admin = \Auth::guard('admin')->user();
        
        if(!\Hash::check($request->password, $admin->password))
        {
            return redirect(route('categories.index'))->with('error', trans('messages.categories.delete.invalid_password'));
        }
        

        $category = Category::find($id);
        
        if($category->delete())
        {
            return redirect(route('categories.index'))->with('success', trans('messages.categories.delete.success'));
        }
        return redirect(route('categories.index'))->with('error', trans('messages.categories.delete.error'));
    }
}
