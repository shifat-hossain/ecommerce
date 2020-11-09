<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Slider;
use File;
use Storage;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_slider'] = Slider::all();
        return view('admin.slider.all_slider', $data);
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
        $slider = new Slider;
        
        $request->validate([
            'slider_title' => 'required|max:255',
            'slider_text' => 'required',
            'slider_image' => 'required|file|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        $slider->slider_title = $request->slider_title;
        $slider->slider_text = $request->slider_text;
        $slider->slider_tag = $request->slider_tag;
        $path = $request->file('slider_image')->store('sliders');
        $slider->slider_image = $path;

        $slider->save();
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
        $data['slider_info'] = Slider::find($id);
        //echo "<pre>";print_r($data['slider_info']);die();
        return view('admin.slider.edit_slider', $data);
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
        $slider = Slider::find($id);
        
        //echo "<pre>";print_r($slider);die();
        $request->validate([
            'slider_title' => 'required|max:255',
            'slider_text' => 'required',
//            'slider_tag' => 'required|max:100',
            'slider_image' => 'file|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        $slider->slider_title = $request->slider_title;
        $slider->slider_text = $request->slider_text;
        $slider->slider_tag = $request->slider_tag;

        if ($request->slider_image) {
            
            $exists = Storage::get($request->pre_img);

            if ($exists) {
                Storage::delete($request->pre_img);
            }
            
            $path = $request->file('slider_image')->store('sliders');
            $slider->slider_image = $path;
        }

        //echo "<pre>";print_r($type);die();
        $slider->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        return redirect('sliders');
    }
}
