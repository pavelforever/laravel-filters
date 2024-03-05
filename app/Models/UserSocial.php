<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    use HasFactory;

    protected $table = "user_social";
    protected $fillable = ['user_id', 'provider_id', 'provider_token', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
