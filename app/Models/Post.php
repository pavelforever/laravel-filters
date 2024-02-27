<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'post_tags')->using(PostTag::class);
    }
}
