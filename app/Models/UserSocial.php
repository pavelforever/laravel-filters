<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\UserCreated;
use App\Events\UserSocialUpdated;

class UserSocial extends Model
{
    use HasFactory;

    protected $table = "user_social";
    protected $fillable = ['user_id', 'provider_id', 'provider_token', 'provider'];
    protected $dispatchesEvents = [
        'created' => UserCreated::class,
        'updated' => UserSocialUpdated::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
