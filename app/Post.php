<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Post
 *
 * @property int $post_id
 * @property string $account
 * @property string $content
 * @property string $new_com_time
 * @property string|null $update_post_time
 * @property \Carbon\Carbon $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostComment[] $postComments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostImage[] $postImages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostLike[] $postLikes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostLocation[] $postLocations
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereNewComTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatePostTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post withData()
 * @mixin \Eloquent
 */
class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'account', 'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'account');
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    public function postImages()
    {
        return $this->hasMany(PostImage::class, 'post_id');
    }

    public function postLocations()
    {
        return $this->hasMany(PostLocation::class, 'post_id');
    }

    public function scopeWithData($query)
    {
        return $query->withCount('postLikes')
            ->withCount('postComments')
            ->with(['user' => function ($query) {
                $query->select(['account', 'name', 'profile_pic']);
            }]);
    }
}
