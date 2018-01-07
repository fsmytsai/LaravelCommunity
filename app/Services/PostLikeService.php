<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/1/7
 * Time: 下午 08:28
 */

namespace App\Services;

use App\PostLike as PostLikeEloquent;

class PostLikeService
{
    public function createPostLike($postData)
    {
        $post = \App\Post::find($postData['post_id']);
        if(!$post)
            return '無此貼文';

        $postLike = PostLikeEloquent::whereAccount($postData['account'])
            ->wherePostId($postData['post_id'])
            ->first();

        if ($postLike) {
            try {
                $postLike->delete();
            } catch (\Exception $e) {
                return '請求失敗';
            }
        } else {
            PostLikeEloquent::create($postData);
        }

        return '';
    }
}