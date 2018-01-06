<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PostComment
 *
 * @property int $post_com_id
 * @property int $post_id
 * @property string $account
 * @property string $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Post $post
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostComment whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostComment wherePostComId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostComment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostComment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PostComment extends Model
{
    protected $table = 'post_comments';
    protected $primaryKey = 'post_com_id';

    protected $fillable = [
        'post_id', 'account', 'content'
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
