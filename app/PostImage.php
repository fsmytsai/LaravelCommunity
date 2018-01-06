<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PostImage
 *
 * @property int $post_id
 * @property int $img_no
 * @property string $img_name
 * @property-read \App\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostImage whereImgName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostImage whereImgNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostImage wherePostId($value)
 * @mixin \Eloquent
 */
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
