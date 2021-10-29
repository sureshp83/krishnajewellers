<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\CustomerLoan;
use App\Model\CustomerLoanJewellery;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AdminLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.loans.index');
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

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $query = CustomerLoan::selectRaw('customer_loans.id,customer_loans.unique_loan_id,
            CONCAT(customer.first_name," ",customer.last_name) as customer_name,
            customer_loans.loan_amount,customer_loans.status,customer_loans.total_jewellery_cost,
            DATE_FORMAT(customer_loans.created_at,"'.config('constant.DATE_FORMAT_STR').'") as created_date')
            ->leftJoin('users as customer', 'customer.id', 'customer_loans.customer_id');
            
            $query->where(function($query) use($request){
                $query->where('customer_loans.loan_amount', 'like', '%'.$request->search['value'].'%')
                ->orWhere(\DB::raw('CONCAT(customer.first_name," ",customer.last_name)'), 'like', '%'.$request->search['value'].'%')
                ->orWhere('customer.first_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('customer.last_name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('customer_loans.unique_loan_id', 'like', '%'.$request->search['value'].'%');
            });
            
            $loans = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $loans['recordsFiltered'] = $loans['recordsTotal'] = $loans['total'];

            foreach($loans['data'] as $key => $loan)
            {
                
                $params = [
                    'loan' => $loan['id']
                ];

                $deleteRoute = route('loans.destroy', $params);
                $viewRoute = route('loans.show', $params);
                $editRoute = route('loans.edit', $params);
                
                if($loan['status'] == 'PENDING')
                {
                    $status = '<span class="label label-warning">PENDING</span>';
                }
                else if($loan['status'] == 'CLOSED')
                {
                    $status = '<span class="label label-success">CLOSED</span>';
                }

                //$status = ($order['status'] == 'PENDING') ? '<span class="label label-warning">PENDING</span>' : '<span class="label label-success">DELIVERED</span>';
                
                $loans['data'][$key]['status'] = $status;
                $loans['data'][$key]['action'] ='<a href="' . $viewRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View loan detail"><i class="zmdi zmdi-eye"></i></a>&nbsp&nbsp';
                $loans['data'][$key]['action'] .='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit loan detail"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $loans['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="loan" data-type="confirm" title="delete loan detail"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($loans);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = User::selectRaw('users.id,CONCAT(users.first_name," ",users.last_name," (",IFNULL(users.village_name,""),")") as customer_name')->get();
        $categories = Category::selectRaw('categories.id,categories.name as category_name')->get();

        return view('admin.loans.create', compact('customers', 'categories'));
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
            'goldDetail' => 'required',
            'silverDetail' => 'required',
            'loan_amount' => 'required'
        ]);

        $totalJewelleryCost = (!empty($request->goldDetail['total_cost']) ? $request->goldDetail['total_cost'] : 0) + (!empty($request->silverDetail['total_cost']) ? $request->silverDetail['total_cost'] : 0);
        
        $customerLoan = new CustomerLoan();
        $customerLoan->customer_id = $request->customer_id;
        $customerLoan->total_jewellery_cost = $totalJewelleryCost;
        $customerLoan->loan_amount = $request->loan_amount;
        $customerLoan->interest = $request->interest;
        $customerLoan->unique_loan_id = '#LON'.\Str::random(4).substr(time(),5);

        if($customerLoan->save())
        {
            if(!empty($request->goldDetail))
            {
                $customerLoanJew = new CustomerLoanJewellery();
                $customerLoanJew->loan_id = $customerLoan->id;
                $customerLoanJew->category_id = 1; // Gold
                $customerLoanJew->jewellery_name = $request->goldDetail['jewellery_name'];
                $customerLoanJew->description = $request->goldDetail['description'];
                $customerLoanJew->weight = $request->goldDetail['weight'];
                $customerLoanJew->current_rate = $request->goldDetail['current_rate'];
                $customerLoanJew->total_cost = $request->goldDetail['total_cost'];

                $customerLoanJew->save();
            }

            if(!empty($request->silverDetail))
            {
                $customerLoanJew = new CustomerLoanJewellery();
                $customerLoanJew->loan_id = $customerLoan->id;
                $customerLoanJew->category_id = 2; // Gold
                $customerLoanJew->jewellery_name = $request->silverDetail['jewellery_name'];
                $customerLoanJew->description = $request->silverDetail['description'];
                $customerLoanJew->weight = $request->silverDetail['weight'];
                $customerLoanJew->current_rate = $request->silverDetail['current_rate'];
                $customerLoanJew->total_cost = $request->silverDetail['total_cost'];

                $customerLoanJew->save();
            }

            return redirect(route('loans.index'))->with('success', trans('messages.loans.add.success'));
        }

        return redirect(route('loans.index'))->with('error', trans('messages.loans.add.error'));
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
    public function edit(CustomerLoan $loan)
    {
        $loanDetail = $loan->load('loan_jewellary');
        
        $jewelleryData = [];
        foreach($loanDetail->loan_jewellary as $key => $jewellery)
        {
            $jewelleryData[$jewellery->category_id] = [
                'jewellery_name' => $jewellery->jewellery_name,
                'description' => $jewellery->description,
                'weight' => $jewellery->weight,
                'current_rate' => $jewellery->current_rate,
                'total_cost' => $jewellery->total_cost
            ];
        }

        
        $customers = User::selectRaw('users.id,CONCAT(users.first_name," ",users.last_name," (",IFNULL(users.village_name,""),")") as customer_name')->get();
        $categories = Category::selectRaw('categories.id,categories.name as category_name')->get();

        $count = count($jewelleryData);
        $keyValue = key($jewelleryData);
        
        return view('admin.loans.create', compact('loanDetail','jewelleryData','keyValue', 'customers','categories','count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerLoan $loan)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'category_id' => 'required',
            'goldDetail' => 'required',
            'silverDetail' => 'required',
            'loan_amount' => 'required'
        ]);
        
        if($request->category_id == 1)
        {
            $totalJewelleryCost = (!empty($request->category_id['total_cost']) ? $request->goldDetail['total_cost'] : 0);
        }
        else if($request->category_id == 1)
        {
            $totalJewelleryCost =(!empty($request->silverDetail['total_cost']) ? $request->silverDetail['total_cost'] : 0);
        }
        else
        {
            $totalJewelleryCost = (!empty($request->category_id['total_cost']) ? $request->goldDetail['total_cost'] : 0) + (!empty($request->silverDetail['total_cost']) ? $request->silverDetail['total_cost'] : 0);
        }
        
        
        $loan->customer_id = $request->customer_id;
        $loan->total_jewellery_cost = $totalJewelleryCost;
        $loan->loan_amount = $request->loan_amount;
        $loan->interest = $request->interest;
       
        if($loan->save())
        {
            CustomerLoanJewellery::where('loan_id', $loan->id)->delete();

            if(!empty($request->goldDetail) && $request->category_id == 1)
            {
                $customerLoanJew = new CustomerLoanJewellery();
                $customerLoanJew->loan_id = $loan->id;
                $customerLoanJew->category_id = 1; // Gold
                $customerLoanJew->jewellery_name = $request->goldDetail['jewellery_name'];
                $customerLoanJew->description = $request->goldDetail['description'];
                $customerLoanJew->weight = $request->goldDetail['weight'];
                $customerLoanJew->current_rate = $request->goldDetail['current_rate'];
                $customerLoanJew->total_cost = $request->goldDetail['total_cost'];

                $customerLoanJew->save();
            }

            if(!empty($request->silverDetail) && $request->category_id == 2)
            {
                $customerLoanJew = new CustomerLoanJewellery();
                $customerLoanJew->loan_id = $loan->id;
                $customerLoanJew->category_id = 1; // Gold
                $customerLoanJew->jewellery_name = $request->silverDetail['jewellery_name'];
                $customerLoanJew->description = $request->silverDetail['description'];
                $customerLoanJew->weight = $request->silverDetail['weight'];
                $customerLoanJew->current_rate = $request->silverDetail['current_rate'];
                $customerLoanJew->total_cost = $request->silverDetail['total_cost'];

                $customerLoanJew->save();
            }

            return redirect(route('loans.index'))->with('success', trans('messages.loans.update.success'));
        }

        return redirect(route('loans.index'))->with('error', trans('messages.loans.update.error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerLoan $loan)
    {
        CustomerLoanJewellery::where('loan_id', $loan->id)->delete();

        if($loan->delete())
        {
            return redirect(route('loans.index'))->with('success', trans('messages.loans.delete.success'));
        }

        return redirect(route('loans.index'))->with('error', trans('messages.loans.delete.error'));
    }
}
