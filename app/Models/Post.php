<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'post_tags','post_id','tag_id')->using(PostTag::class)
        ->wherePivot('deleted_at', null)
        ->withPivot('id')
        ->withTimestamps();
    }

    public function customWithTrashed(){
        return $this->belongsToMany(Tag::class,'post_tags','post_id','tag_id')->using(PostTag::class)
        ->withPivot('id')
        ->withTimestamps();
    }
    public function customOnlyTrashed(){
        return $this->belongsToMany(Tag::class,'post_tags','post_id','tag_id')->using(PostTag::class)
        ->whereNotNull(['deleted_at'])
        ->withPivot('id')
        ->withTimestamps();
    }
}
