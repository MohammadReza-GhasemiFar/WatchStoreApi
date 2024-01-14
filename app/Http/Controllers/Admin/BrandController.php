<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\SliderRequest;
use App\Models\Brand;
use App\Models\Slider;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "لیست برند ها";
        return view('admin.brand.list',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "ایجاد برند";
        return view('admin.brand.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        Brand::createBrand($request);
        return redirect()->route('brands.index')->with('message','برند با موفقیت ایجاد شد.');
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
        $brand = Brand::query()->find($id);
        $title = "ویرایش برند";
        return view('admin.brand.edit',compact('title','brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $image = Brand::saveImage($request->image);
        $brand = Brand::query()->find($id);
        Brand::query()->find($id)->update([
            'title' => $request->input('title'),
            'image'=>$request->image ? $image : $brand->image,
        ]);
        return redirect()->route('brands.index')->with('message','برند با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
