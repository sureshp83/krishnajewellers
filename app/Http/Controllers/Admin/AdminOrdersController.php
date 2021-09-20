<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AdminOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.orders.index');
    }


    /**
     * Load customers data
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

            $query = Order::selectRaw('orders.id,CONCAT(customer.first_name," ",customer.last_name) as customer_name,
            orders.jewellery_name,orders.weight,orders.total_cost,categories.name as category_name,
            DATE_FORMAT(orders.created_at,"'.config('constant.DATE_FORMAT_STR').'") as created_date')
            ->leftJoin('users as customer', 'customer.id', 'orders.customer_id')
            ->leftJoin('categories', 'categories.id', 'orders.category_id');
            $query->where(function($query) use($request){
                $query->where('orders.jewellery_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('orders.total_cost', 'like', '%'.$request->search['value'].'%')
                ->orWhere(\DB::raw('CONCAT(customer.first_name," ",customer.last_name)'), 'like', '%'.$request->search['value'].'%')
                ->orWhere('customer.first_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('customer.last_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('orders.weight', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $orders = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $orders['recordsFiltered'] = $orders['recordsTotal'] = $orders['total'];

            foreach($orders['data'] as $key => $order)
            {
                
                $params = [
                    'order' => $order['id']
                ];

                //$deleteRoute = route('orders.destroy', $params);
                $viewRoute = route('orders.show', $params);
                $editRoute = route('orders.edit', $params);

                $orders['data'][$key]['action'] ='<a href="' . $viewRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View order"><i class="zmdi zmdi-eye"></i></a>&nbsp&nbsp';
                $orders['data'][$key]['action'] .='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit order"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                //$orders['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="order" data-type="confirm" title="delete customer"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
