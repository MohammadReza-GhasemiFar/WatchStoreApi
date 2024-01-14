<?php

namespace App\Models;

use App\Http\Resources\SliderResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Slider extends Model
{
    use HasFactory;

    protected $fillable= [
        'title',
        'url',
        'image'
    ];

    public static function saveImage($file)
    {
        if($file){
            $manager = new ImageManager(new Driver());
            $name = time().'.'.$file->extension();
            $smallImage = $manager->read($file->getRealPath());
            $bigImage = $manager->read($file->getRealPath());
            $smallImage->resize(256,256);
            Storage::disk('local')->put('admin/sliders/small/'.$name,(String) $smallImage->toPng());
            Storage::disk('local')->put('admin/sliders/big/'.$name,(String) $bigImage->toPng());
            return $name;
        } else{
            return '';
        }
    }

    public static function getSliders()
    {
        $sliders = Slider::query()->get();
        return SliderResource::collection($sliders);
    }
}
