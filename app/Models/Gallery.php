<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
         'image',
        'product_id'
        ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function saveImage($file)
    {
        if($file){
            $manager = new ImageManager(new Driver());
            $name = time().'.'.$file->extension();
            $smallImage = $manager->read($file->getRealPath());
            $bigImage = $manager->read($file->getRealPath());
            $smallImage->resize(256,256);
            Storage::disk('local')->put('admin/products/small/'.$name,(String) $smallImage->toPng());
            Storage::disk('local')->put('admin/products/big/'.$name,(String) $bigImage->toPng());
            return $name;
        } else{
            return '';
        }
    }
}
