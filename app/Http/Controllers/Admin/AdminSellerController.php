<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ModelUser;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AdminSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.seller.index');
    }


    /**
     * Load sellers data
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

            $query = User::where(['role_id' => 2,'last_step' => 4])->selectRaw('users.id,phone_number,name,approval,
            users.email,users.is_active,CONCAT("'.$S3avatar.'",IFNULL(profile_image,"default-user.png")) AS profile_image');
            
            $query->where(function($query) use($request){
                $query->orWhere('users.name', 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.phone_number', 'like', '%'.$request->search['value'].'%')
                ->orWhere('users.email', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $sellers = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $sellers['recordsFiltered'] = $sellers['recordsTotal'] = $sellers['total'];

            foreach($sellers['data'] as $key => $seller)
            {
                
                $params = [
                    'seller' => $seller['id']
                ];

                $deleteRoute = route('sellers.destroy', $params);
                $viewRoute = route('sellers.show', $params);
                $statusRoute = route('sellers.status', $params);
                $approvalRoute = route('sellers.approval', $params);
                
                $status = ($seller['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                
                $approval = ($seller['approval'] == 1) ? '<span class="label label-success">Approved</span>' : '<span class="label label-danger">Not Approved</span>';

                $sellers['data'][$key]['profile_image'] = '<img src="'.$seller['profile_image'].'" class="rounded-circle" width="40" height="40">';
                $sellers['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                $sellers['data'][$key]['approval'] = '<a href="javascript:void(0);" data-url="' . $approvalRoute . '" class="btnChangeApproval">'. $approval.'</a>';
                $sellers['data'][$key]['action'] ='<a href="' . $viewRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="View seller"><i class="zmdi zmdi-eye"></i></a>&nbsp&nbsp';
                $sellers['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="seller" data-type="confirm" title="delete customer"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($sellers);
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

        $S3avatar = config('constant.S3_AVATAR');
        $S3store = config('constant.S3_STORE');

        $sellerDetail = User::where('role_id',2)->where('id', $id)
        ->selectRaw('users.id,phone_number,name,DATE_FORMAT(users.created_at,"'.config('constant.DATE_FORMAT_STR').'") as join_date,
        users.email,users.is_active,CONCAT("'.$S3avatar.'",IFNULL(profile_image,"default-user.png")) AS profile_image')
        ->with(['stores' => function($query) use($S3store){
            $query->selectRaw('stores.*,CONCAT("'.$S3store.'", IFNULL(stores.store_logo,"default-user.png")) as store_logo')
            ->with(['storeCategories' => function($query){
                $query->selectRaw('store_categories.id,store_categories.seller_id,store_categories.store_id,
                store_categories.category_id,categories.category')
                ->leftJoin('categories', 'categories.id', 'store_categories.category_id');
            }])
            ->with(['storeAvailability' => function($query){
                $query->selectRaw('store_availabilities.id,store_availabilities.seller_id,store_availabilities.store_id,
                store_availabilities.day_name,store_availabilities.start_time,store_availabilities.end_time,store_availabilities.is_closed');
            }]);
        }])
        ->first();
       
        return view('admin.seller.view', compact('sellerDetail'));

    }


    /**
     * Change user status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(User $seller)
    {
        if (empty($seller))
        {
            return redirect(route('sellers.index'))->with('error', trans('messages.sellers.not_found_admin'));
        }

        $seller->is_active = !$seller->is_active;
        
        if ($seller->save()) 
        {
            $status = $seller->is_active ? 'Active' : 'Inactive';

            return redirect(route('sellers.index'))->with('success', trans('messages.sellers.status.success', ['status' => $status]));
        }

        return redirect(route('sellers.index'))->with('error', trans('messages.sellers.status.error'));
    }

    /**
     * Change user approval
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeApproval(User $seller)
    {
        if (empty($seller))
        {
            return redirect(route('sellers.index'))->with('error', trans('messages.sellers.not_found_admin'));
        }

        $seller->approval = !$seller->approval;
        
        if ($seller->save()) 
        {
            $status = $seller->approval ? 'Approved' : 'Not approved';

            return redirect(route('sellers.index'))->with('success', trans('messages.sellers.approval.success', ['status' => $status]));
        }

        return redirect(route('sellers.index'))->with('error', trans('messages.sellers.approval.error'));
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
        $seller = User::find($id);
        
        if($seller->delete())
        {
            return redirect(route('sellers.index'))->with('success', trans('messages.sellers.delete.success'));
        }
        return redirect(route('sellers.index'))->with('error', trans('messages.sellers.delete.error'));
    }
}
