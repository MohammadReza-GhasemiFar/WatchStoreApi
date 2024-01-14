<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'parent_id'
    ];
    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id','id')->withDefault(['title'=>'-----']);
    }

    public function child()
    {
        return $this->hasMany(self::class,'parent_id','id');
    }

    public static function saveImage($file)
    {
        if($file){
            $manager = new ImageManager(new Driver());
            $name = time().'.'.$file->extension();
            $smallImage = $manager->read($file->getRealPath());
            $bigImage = $manager->read($file->getRealPath());
            $smallImage->resize(256,256);
            Storage::disk('local')->put('admin/categories/small/'.$name,(String) $smallImage->toPng());
            Storage::disk('local')->put('admin/categories/big/'.$name,(String) $bigImage->toPng());
            return $name;
        } else{
            return '';
        }
    }

    public static function getAllCategories()
    {
        $categories = self::query()->get();
        return CategoryResource::collection($categories);
    }
}
