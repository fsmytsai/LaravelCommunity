<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/1/3
 * Time: 下午 09:15
 */

namespace App\Services;

use App\Post as PostEloquent;

class PostService
{
    public function getPosts($showedPostIdArr)
    {
        return PostEloquent::whereNotIn('post_id', $showedPostIdArr)
            ->orderByDesc('updated_at')
            ->take(15)
            ->get();
    }

    public function getUserAllPosts($account)
    {
        return PostEloquent::where('account', $account)->get();
    }

    public function createPost($postData)
    {
        $postData['account'] = $postData['user']['account'];
        $post = PostEloquent::create($postData);
        return $post->post_id;
    }

    public function updatePost($putData)
    {
        $post = PostEloquent::find($putData['post_id']);
        if ($post) {
            if ($post->account == $putData['user']['account']) {
                $putData['account'] = $putData['user']['account'];
                $post->update($putData);
                return '';
            } else {
                return '無權修改';
            }
        }
        return '無此文章';
    }

    public function deletePost($deleteData)
    {
        $post = PostEloquent::find($deleteData['post_id']);
        if ($post) {
            if ($post->account == $deleteData['user']['account']) {
                try {
                    $post->delete();
                } catch (\Exception $ex) {
                    return '刪除失敗';
                }
                return '';
            } else {
                return '無權刪除';
            }
        }
        return '無此文章';
    }
}