<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Post
 *
 * @property int $post_id
 * @property string $account
 * @property string $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostComment[] $postComments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostImage[] $postImages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostLike[] $postLikes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostLocation[] $postLocations
 */
class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';

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
}
