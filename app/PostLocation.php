<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PostLocation
 *
 * @property int $post_id
 * @property string $place_id
 * @property string $location_name
 * @property-read \App\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostLocation whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostLocation wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostLocation wherePostId($value)
 * @mixin \Eloquent
 */
class PostLocation extends Model
{
    protected $table = 'post_locations';
    protected $primaryKey = ['post_id', 'place_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'post_id', 'place_id', 'location_name'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
