<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ModelCountry;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AdminCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.country.index');
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

            $query = Country::selectRaw('countries.id,countries.sortname,
            countries.name,countries.is_active');
            
            $query->where(function($query) use($request){
                $query->orWhere('countries.sortname', 'like', '%'.$request->search['value'].'%')
                ->orWhere('countries.name', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $countries = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $countries['recordsFiltered'] = $countries['recordsTotal'] = $countries['total'];

            foreach($countries['data'] as $key => $country)
            {
                
                $params = [
                    'country' => $country['id']
                ];

                $deleteRoute = route('countries.destroy', $params);
                $statusRoute = route('countries.status', $params);
                
                $status = ($country['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                
                $countries['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                //$countries['data'][$key]['action'] = '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="country" data-type="confirm" title="delete country"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($countries);
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
     * Change category status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(Country $country)
    {
        if (empty($country))
        {
            return redirect(route('countries.index'))->with('error', trans('messages.countries.not_found_admin'));
        }

        $country->is_active = !$country->is_active;
        
        if ($country->save()) 
        {
            $status = $country->is_active ? 'Active' : 'Inactive';

            return redirect(route('countries.index'))->with('success', trans('messages.countries.status.success', ['status' => $status]));
        }

        return redirect(route('countries.index'))->with('error', trans('messages.countries.status.error'));
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
