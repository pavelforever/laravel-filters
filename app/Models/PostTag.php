<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostTag extends Pivot
{
    use SoftDeletes;
    public $incrementing = true;
    protected $table = 'post_tags';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function tags(){
        return $this->belongsTo(Tag::class,'tag_id');
    }
    public function posts(){
        return $this->belongsTo(Post::class,'post_id');
    }
}
