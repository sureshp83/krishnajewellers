<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ModelSlider;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.slider.index');
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

            $S3slider = config('constant.S3_SLIDER');

            $start = ($request->start == 0) ? 1 : (($request->start) * ($request->length) + 1);

            $orderDir = $request->order[0]['dir'];
            $orderColumnId = $request->order[0]['column'];
            $orderColumn = str_replace('"','', $request->columns[$orderColumnId]['name']);

            $query = Slider::selectRaw('sliders.id,sliders.name,
            CONCAT("'.$S3slider.'",IFNULL(sliders.slider_image,"default-user.png")) as slider_image,sliders.is_active');
            
            $query->where(function($query) use($request){
                $query->orWhere('sliders.name', 'like', '%'.$request->search['value'].'%');
            });
            
          
            $sliders = $query->orderBy($orderColumn, $orderDir)
            ->paginate($request->length)->toArray();
            
            $sliders['recordsFiltered'] = $sliders['recordsTotal'] = $sliders['total'];

            foreach($sliders['data'] as $key => $slider)
            {
                
                $params = [
                    'slider' => $slider['id']
                ];

                $deleteRoute = route('sliders.destroy', $params);
                $editRoute = route('sliders.edit', $params);
                $statusRoute = route('sliders.status', $params);
                
                $status = ($slider['is_active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                $sliders['data'][$key]['slider_image'] = '<img src="'.$slider['slider_image'].'" class="img-fluid img-thumbnail wh-60">';
                $sliders['data'][$key]['status'] = '<a href="javascript:void(0);" data-url="' . $statusRoute . '" class="btnChangeStatus">'. $status.'</a>';
                $sliders['data'][$key]['action'] ='<a href="' . $editRoute . '" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5" title="Edit slider"><i class="zmdi zmdi-edit"></i></a>&nbsp&nbsp';
                $sliders['data'][$key]['action'] .= '<a href="javascript:void(0);" data-url="'.$deleteRoute.'" class="btn btn-raised waves-effect waves-float waves-light-blue m-l-5 btnDelete" data-title="slider" data-type="confirm" title="delete slider"><i class="zmdi zmdi-delete"></i> </a>&nbsp&nbsp';
            }   
        }
        
        return json_encode($sliders);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
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
            'name' => 'required',
            'slider_image' => 'required'
        ]);
        
        $slider = new Slider();
        $slider->name = $request->name;
        $slider->is_active = $request->is_active;

        if(!empty($request->slider_image))
        {
            $name = time() . $request->file('slider_image')->getClientOriginalName();
            $filePath = 'wafrahbazaar/sliders/' . $name;
            
            Storage::disk('s3')->put($filePath, file_get_contents($request->file('slider_image')),'public');
                
            $slider->slider_image = $name;
        }

        if($slider->save())
        {
            return redirect(route('sliders.index'))->with('success', trans('messages.sliders.add.success'));
        }

        return redirect(route('sliders.index'))->with('error', trans('messages.sliders.add.error'));
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
     * Change user status
     * @param Request $team
     * 
     * @return Response view
     */
    public function changeStatus(Slider $slider)
    {
        if (empty($slider))
        {
            return redirect(route('sliders.index'))->with('error', trans('messages.sliders.not_found_admin'));
        }

        $slider->is_active = !$slider->is_active;
        
        if ($slider->save()) 
        {
            $status = $slider->is_active ? 'Active' : 'Inactive';

            return redirect(route('sliders.index'))->with('success', trans('messages.sliders.status.success', ['status' => $status]));
        }

        return redirect(route('sliders.index'))->with('error', trans('messages.sliders.status.error'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $S3slider = config('constant.S3_SLIDER');

        $sliderDetail = Slider::where('sliders.id', $slider->id)
        ->selectRaw('sliders.id,sliders.name,
            CONCAT("'.$S3slider.'",IFNULL(sliders.slider_image,"default-user.png")) as slider_image,sliders.is_active')
            ->first();
        
        return view('admin.slider.create', compact('sliderDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'name' => 'required',
            'slider_image' => 'nullable'
        ]);

        $slider->name = $request->name;
        $slider->is_active = $request->is_active;

        if(!empty($request->slider_image))
        {
            $name = time() . $request->file('slider_image')->getClientOriginalName();
            $filePath = 'wafrahbazaar/sliders/' . $name;
            
            Storage::disk('s3')->put($filePath, file_get_contents($request->file('slider_image')),'public');
                
            $slider->slider_image = $name;
        }

        if($slider->save())
        {
            return redirect(route('sliders.index'))->with('success', trans('messages.sliders.update.success'));
        }

        return redirect(route('sliders.index'))->with('error', trans('messages.sliders.update.error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if($slider->delete())
        {
            return redirect(route('sliders.index'))->with('success', trans('messages.sliders.delete.success'));
        }

        return redirect(route('sliders.index'))->with('success', trans('messages.sliders.delete.success'));
    }
}
