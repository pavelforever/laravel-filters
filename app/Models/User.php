<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use function Illuminate\Events\queueable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use Billable;
    const isAdmin = 0;
    const isSimpleUser = 1;


    protected $guarded = [
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'provider',
        'provider_id',
        'provider_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function getRoles(){
        return [
            self::isAdmin => 'Admin',
            self::isSimpleUser => 'User'
        ];
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function socials()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function purchases(){
        return $this->belongsToMany(Product::class,'purchased','user_id','product_id')->withPivot(['quantity'])->withTimestamps();
    }

    public function hasSocialLogin(){
        return $this->socials()->exists();
    }
}
