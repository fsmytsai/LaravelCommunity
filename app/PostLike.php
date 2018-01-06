<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PostLike
 *
 * @property int $post_like_id
 * @property int $post_id
 * @property string $account
 * @property \Carbon\Carbon $created_at
 * @property-read \App\Post $post
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostLike whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostLike wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostLike wherePostLikeId($value)
 * @mixin \Eloquent
 */
class PostLike extends Model
{
    protected $table = 'post_likes';
    protected $primaryKey = 'post_like_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'post_id', 'account'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
