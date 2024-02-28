<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function posts(){
        return $this->belongsToMany(Post::class,'post_tags','tag_id','post_id')->using(PostTag::class)
        ->wherePivot('deleted_at', null)
        ->withPivot('id')
        ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tag) {
            // Detach posts when tag is deleted
            $tag->posts()->detach();
        });

        static::restoring(function ($tag) {
            // Restore posts when tag is restored
            $tag->posts()->withTrashed()->attach(Post::withTrashed()->pluck('id')->toArray());
        });
    }
}
