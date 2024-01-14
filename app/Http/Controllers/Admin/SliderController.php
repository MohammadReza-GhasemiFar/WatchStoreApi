<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "لیست اسلایدرها";
        return view('admin.slider.list', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "ایجاد اسلایدر";
        return view('admin.slider.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $image = Slider::saveImage($request->image);
        Slider::query()->create([
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'image' => $image
        ]);
        return redirect()->route('sliders.index')->with('message', 'اسلایدر با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = Slider::query()->find($id);
        $title = "ویرایش اسلایدر";
        return view('admin.slider.edit', compact('title', 'slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);
        $image = Slider::saveImage($request->image);
        $slider = Slider::query()->find($id);
        Slider::query()->find($id)->update([
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'image' =>$request->image ? $image : $slider->image,
        ]);
        return redirect()->route('sliders.index')->with('message', 'اسلایدر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
