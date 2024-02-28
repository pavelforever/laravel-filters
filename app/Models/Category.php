<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function countPosts()
    {
        return $this->posts()->count();
    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($category) {
    //         // Detach posts when category is deleted
    //         $category->posts()->update(['category_id' => null]);
    //     });

    //     static::restoring(function ($category) {
    //         // Restore posts when category is restored
    //         $category->posts()->withTrashed()->update(['category_id' => $category->id]);
    //     });
    // }
}
