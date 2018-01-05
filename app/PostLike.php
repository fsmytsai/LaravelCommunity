<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $table = 'post_likes';
    protected $primaryKey = 'post_like_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'post_id', 'account'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
