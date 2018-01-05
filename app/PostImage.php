<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $table = 'post_images';
    protected $primaryKey = ['post_id', 'img_no'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'post_id', 'img_no', 'img_name'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
