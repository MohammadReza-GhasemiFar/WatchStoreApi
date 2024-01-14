<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'photo',
        'phone',
        'status',
        'is_admin',
        'user_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function saveImage($file)
    {
        if($file){
            $manager = new ImageManager(new Driver());
            $name = time().'.'.$file->extension();
            $smallImage = $manager->read($file->getRealPath());
            $bigImage = $manager->read($file->getRealPath());
            $smallImage->resize(256,256);
            Storage::disk('local')->put('admin/users/small/'.$name,(String) $smallImage->toPng());
            Storage::disk('local')->put('admin/users/big/'.$name,(String) $bigImage->toPng());
            return $name;
        } else{
            return '';
        }
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public static function updateUserInfo($user,$request)
    {
        $image = self::saveImage($request->file);

        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'photo' => $image,
        ]);
        $user->addresses()->create([
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'lat' => $request->input('lat'),
            'lang' => $request->input('lang'),
        ]);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
