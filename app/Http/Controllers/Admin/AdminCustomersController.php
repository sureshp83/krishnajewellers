<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AdminCustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customers.index');
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

            $query = User::selectRaw('users.id,phone_number,CONCAT(first_name," ",last_name) as name,users.village_name,
            users.email,CONCAT("'.$S3avatar.'",IFNULL(profile_image,"default-user.png")) AS profile_image');
            
            $query->where(function($query) use($request){
                $query->where('users.first_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.last_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere(\DB::raw('CONCAT(users.first_name," ",users.last_name)'), 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.phone_number', 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.email', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $customers = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $customers['recordsFiltered'] = $customers['recordsTotal'] = $customers['total'];

            foreach($customers['data'] as $key => $customer)
            {
                
                $params = [
                    'customer' => $customer['id']
                ];

                $deleteRoute = route('customers.destroy', $params);
                $viewRoute = route('customers.show', $params);
                $editRoute = route('customers.edit', $params);

                $customers['data'][$key]['profile_image'] = '<img src="'.url(config('constant.CUSTOMER_AVATAR').$customer['profile_image']).'" class="rounded-circle" width="40" height="40">';
                
                $customers['data'][$key]['action'] ='<a href="' . $viewRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View customer"><i class="zmdi zmdi-eye"></i></a>&nbsp&nbsp';
                $customers['data'][$key]['action'] .='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit customer"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $customers['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="customer" data-type="confirm" title="delete customer"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.create');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable',
            'village_name' => 'required',
            'address' => 'required',
            'description' => 'nullable',
            'phone_number' => 'required',
            'alternate_phone_number' => 'nullable'
        ]);

        $customer = new User();
        $customer->fill($request->all());

        if($request->has('profile_image'))
        {
            $basePath = config('constant.CUSTOMER_AVATAR');
            $image = $request->file('profile_image');
            $fileName = time().'_'.strtolower(\Str::random(6)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path($basePath);
            
            if($image->move($destinationPath, $fileName))
            {
                chmod($destinationPath.'/'.$fileName,0777);
                $customer->profile_image = $fileName;
            }
        }
        
        if($customer->save())
        {
            return redirect(route('customers.index'))->with('success', trans('messages.customers.add.success'));
        }

        return redirect(route('customers.index'))->with('error', trans('messages.customers.add.error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $S3avatar = config('constant.CUSTOMER_AVATAR');

        $customerDetail = User::where('id', $id)
        ->selectRaw('users.id,phone_number,users.alternate_phone_number,users.village_name,
        CONCAT(first_name," ",last_name) as name,DATE_FORMAT(users.created_at,"'.config('constant.DATE_FORMAT_STR').'") as join_date,
        users.email,CONCAT("'.$S3avatar.'",IFNULL(profile_image,"default-user.png")) AS profile_image')
        ->with('orders')
        ->first();
        
        return view('admin.customers.view', compact('customerDetail'));

    }


    /**
     * Change user status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(User $customer)
    {
        if (empty($customer))
        {
            return redirect(route('customers.index'))->with('error', trans('messages.customers.not_found_admin'));
        }

        $customer->is_active = !$customer->is_active;
        
        if ($customer->save()) 
        {
            $status = $customer->is_active ? 'Active' : 'Inactive';

            return redirect(route('customers.index'))->with('success', trans('messages.customers.status.success', ['status' => $status]));
        }

        return redirect(route('customers.index'))->with('error', trans('messages.customers.status.error'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $S3avatar = url(config('constant.CUSTOMER_AVATAR'));

        $customerDetail = User::where('id', $id)
        ->selectRaw('users.*,CONCAT("'.$S3avatar.'","/",IFNULL(profile_image,"default-user.png")) AS profile_image')
        ->first();
       
        return view('admin.customers.create', compact('customerDetail'));

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
       // dd($request->all());
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable',
            'village_name' => 'required',
            'address' => 'required',
            'description' => 'nullable',
            'phone_number' => 'required',
            'alternate_phone_number' => 'nullable'
        ]);

        $customer = User::find($request->customerId);
        $customer->fill($request->all());

        if($request->has('profile_image'))
        {
            $basePath = config('constant.CUSTOMER_AVATAR');
            $image = $request->file('profile_image');
            $fileName = time().'_'.strtolower(\Str::random(6)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path($basePath);
            
            if($image->move($destinationPath, $fileName))
            {
                chmod($destinationPath.'/'.$fileName,0777);
                $customer->profile_image = $fileName;
            }
        }
        
        if($customer->save())
        {
            return redirect(route('customers.index'))->with('success', trans('messages.customers.add.success'));
        }

        return redirect(route('customers.index'))->with('error', trans('messages.customers.add.error'));
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
            return redirect(route('customers.index'))->with('error', trans('messages.customers.delete.invalid_password'));
        }
        
        $customer = User::find($id);
        
        if($customer->delete())
        {
            return redirect(route('customers.index'))->with('success', trans('messages.customers.delete.success'));
        }
        return redirect(route('customers.index'))->with('error', trans('messages.customers.delete.error'));
    }
}
