<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code'
    ] ;

    public function products()
    {
        return $this->belongsToMany(Product::class,'color_product');
    }

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
}
