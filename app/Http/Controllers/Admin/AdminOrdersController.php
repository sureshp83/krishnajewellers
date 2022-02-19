<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Order;
use App\Model\OrderPayment;
use App\Model\User;
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

            $start = ($request->start == 0) ? 1 : (($request->start) * ($request->length) + 1);

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $query = Order::selectRaw('orders.id,orders.unique_order_id,CONCAT(customer.first_name," ",customer.last_name) as customer_name,
            orders.jewellery_name,orders.weight,orders.total_cost,categories.name as category_name,orders.status,
            DATE_FORMAT(orders.created_at,"'.config('constant.DATE_FORMAT_STR').'") as created_date')
            ->leftJoin('users as customer', 'customer.id', 'orders.customer_id')
            ->leftJoin('categories', 'categories.id', 'orders.category_id');
            $query->where(function($query) use($request){
                $query->where('orders.jewellery_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('orders.total_cost', 'like', '%'.$request->search['value'].'%')
                ->orWhere(\DB::raw('CONCAT(customer.first_name," ",customer.last_name)'), 'like', '%'.$request->search['value'].'%')
                ->orWhere('customer.first_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('customer.last_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('orders.weight', 'like', '%'.$request->search['value'].'%')
                ->orWhere('orders.unique_order_id', 'like', '%'.$request->search['value'].'%');
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
                
                if($order['status'] == 'PENDING')
                {
                    $status = '<span class="label label-warning">PENDING</span>';
                }
                else if($order['status'] == 'PAYMENT_DONE')
                {
                    $status = '<span class="label label-primary">PAYMENT DONE</span>';
                }
                else if($order['status'] == 'DELIVERED')
                {
                    $status = '<span class="label bg-pink">DELIVERED</span>';
                }
                else if($order['status'] == 'CLOSED')
                {
                    $status = '<span class="label label-success">CLOSED</span>';
                }

                //$status = ($order['status'] == 'PENDING') ? '<span class="label label-warning">PENDING</span>' : '<span class="label label-success">DELIVERED</span>';
                
                $orders['data'][$key]['status'] = $status;
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
        $customers = User::selectRaw('users.id,CONCAT(users.first_name," ",users.last_name," (",IFNULL(users.village_name,""),")") as customer_name')->get();
        $categories = Category::selectRaw('categories.id,categories.name as category_name')->get();

        return view('admin.orders.create', compact('customers','categories'));
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
            'customer_id' => 'required',
            'category_id' => 'required',
            'jewellery_name' => 'required',
            'description' => 'nullable',
            'weight' => 'required',
            'weight_type' => 'required',
            'current_rate' => 'required'
        ]);

        $order = new Order();
        $order->fill($request->all());
        $order->unique_order_id = '#ORD'.\Str::random(4).substr(time(),5);
        $order->total_cost = $request->current_rate + $request->making_charge + $request->other_charge;
        
        if($request->has('design_image'))
        {
            $basePath = config('constant.DESIGN_PATH');
            $image = $request->file('design_image');
            $fileName = time().'_'.strtolower(\Str::random(6)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path($basePath);
            
            if($image->move($destinationPath, $fileName))
            {
                chmod($destinationPath.'/'.$fileName,0777);
                $order->design_image = $fileName;
            }
        }

        if($order->save())
        {
            if($request->payment_type != "3")
            {
                $orderPayment = new OrderPayment();
                $orderPayment->order_id = $order->id;
                $orderPayment->order_amount = $order->total_cost;
                $orderPayment->paid_amount = $request->paid_amount;
                $orderPayment->remain_amount = ($order->total_cost - $request->paid_amount);
                $orderPayment->save();
    
            }
            
            return redirect(route('orders.index'))->with('success', trans('messages.orders.add.success'));
        }

        return redirect(route('orders.index'))->with('error', trans('messages.orders.add.error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $S3_PATH = url(config('constant.DESIGN_PATH'));

        $orderDetail = Order::where('orders.id', $order->id)->selectRaw('orders.*,categories.name as category_name,
        CONCAT(users.first_name," ",users.last_name," (",IFNULL(users.village_name,""),")") as customer_name,
        CONCAT("'.$S3_PATH.'","/",IFNULL(design_image,"default-user.png")) as design_image,orders.payment_type,
        DATE_FORMAT(orders.created_at,"'.config('constant.DATE_TIME_FORMAT').'") as order_datetime')
        ->leftJoin('users','users.id', 'orders.customer_id')
        ->leftJoin('categories','categories.id', 'orders.category_id')
        ->first();
       // dd($orderDetail);
        return view('admin.orders.view', compact('orderDetail'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $S3_PATH = url(config('constant.DESIGN_PATH'));

        $orderDetail = Order::where('id', $order->id)->selectRaw('orders.*,
        CONCAT("'.$S3_PATH.'","/",IFNULL(design_image,"default-user.png")) as design_image,
        (select order_payments.paid_amount from order_payments where order_payments.order_id=orders.id order by order_payments.id limit 1) as paid_payment')        
        ->with('order_payments')
        ->first();
        
        $customers = User::selectRaw('users.id,CONCAT(users.first_name," ",users.last_name," (",IFNULL(users.village_name,""),")") as customer_name')->get();
        $categories = Category::selectRaw('categories.id,categories.name as category_name')->get();

        return view('admin.orders.create', compact('customers','categories', 'orderDetail'));
    }

    /**
     * Add more order payment
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function addMoreOrderPayment(Request $request)
    {
        $this->validate($request, [
            'paid_payment' => 'required',
            'order_id' => 'required'
        ]);

        $order = Order::find($request->order_id);
       
        if(empty($order))
        {
            return $this->toJson([], trans('messages.orders.not_found'), 0);
        }

        if($order->status == "PAYMENT_DONE")
        {
            return $this->toJson([], trans('messages.orders.payment_already_done'), 0);
        }

        $lastPayment = OrderPayment::where('order_id', $request->order_id)->latest('id')->first();
        
        $orderPayment = new OrderPayment();
        $orderPayment->order_id = $request->order_id;
        $orderPayment->order_amount = $order->total_cost;
        $orderPayment->paid_amount = $request->paid_payment;
        $orderPayment->remain_amount = ((($order->total_cost - $request->paid_payment) > 0) ? ($order->total_cost - $request->paid_payment) : 0);

        if(!empty($lastPayment))
        {
            if($lastPayment->remain_amount == 0)
            {
                return $this->toJson([], trans('messages.orders.payment_already_done'), 0);
            }

            $orderPayment->remain_amount = ((($lastPayment->remain_amount - $request->paid_payment) > 0) ? ($lastPayment->remain_amount - $request->paid_payment) : 0);
        }
        
        if($orderPayment->save())
        {
            if($orderPayment->remain_amount == 0)
            {
                $order->status = 'PAYMENT_DONE';
                $order->save();
            }

            return $this->toJson([], trans('messages.orders.payment_success'), 1);
        }
        
    }

    /**
     * change order status
     * @param Request $request
     * 
     * @return Response Json
     * 
     */
    public function changeOrderStatus(Request $request)
    {
        
        $this->validate($request, [
            'orderStatus' => 'required',
            'orderId' => 'required'
        ]);

        $order = Order::find($request->orderId);
        $order->status = $request->orderStatus;
        
        if($order->save())
        {
            return redirect()->back()->with('success', trans('messages.orders.status.success'));
           
        }
        
        return redirect()->back()->with('success', trans('messages.orders.status.error'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'category_id' => 'required',
            'jewellery_name' => 'required',
            'description' => 'nullable',
            'weight' => 'required',
            'current_rate' => 'required'
        ]);
       
        
        $order->fill($request->all());
        $order->total_cost = $request->current_rate + $request->making_charge + $request->other_charge;

        if($request->has('design_image'))
        {
            $basePath = config('constant.DESIGN_PATH');
            $image = $request->file('design_image');
            $fileName = time().'_'.strtolower(\Str::random(6)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path($basePath);
            
            if($image->move($destinationPath, $fileName))
            {
                chmod($destinationPath.'/'.$fileName,0777);
                $order->design_image = $fileName;
            }
        }

        if($order->save())
        {
            if(!empty($request->paid_amount))
            {
                $orderPayment = new OrderPayment();
                $orderPayment->order_id = $order->id;
                $orderPayment->order_amount = $order->total_cost;
                $orderPayment->paid_amount = $request->paid_amount;
                $orderPayment->remain_amount = ($order->total_cost - $request->paid_amount);
                $orderPayment->save();
            }

            return redirect(route('orders.index'))->with('success', trans('messages.orders.update.success'));
        }

        return redirect(route('orders.index'))->with('error', trans('messages.orders.update.error'));
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
