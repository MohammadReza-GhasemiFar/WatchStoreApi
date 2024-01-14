<?php

namespace App\Models;

use App\Http\Resources\BrandResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image'
    ] ;

    public static function saveImage($file)
    {
        if($file){
            $manager = new ImageManager(new Driver());
            $name = time().'.'.$file->extension();
            $smallImage = $manager->read($file->getRealPath());
            $bigImage = $manager->read($file->getRealPath());
            $smallImage->resize(256,256);
            Storage::disk('local')->put('admin/brands/small/'.$name,(String) $smallImage->toPng());
            Storage::disk('local')->put('admin/brands/big/'.$name,(String) $bigImage->toPng());
            return $name;
        } else{
            return '';
        }
    }

    public static function createBrand($request)
    {
        $image = self::saveImage($request->image);
        Brand::query()->create([
            'title' => $request->input('title'),
            'image' =>$image
        ]);
    }

    public static function getAllBrands()
    {
        $brands = self::query()->get();
        return BrandResource::collection($brands);
    }
}
