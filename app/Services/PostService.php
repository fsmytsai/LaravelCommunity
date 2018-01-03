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

    public function createPost($postData, $executorAccount)
    {
        $postData['account'] = $executorAccount;
        $post = PostEloquent::create($postData);
        return $post->post_id;
    }

    public function updatePost($putData, $executorAccount)
    {
        $post = PostEloquent::find($putData['post_id']);
        if ($post) {
            if ($post->account == $executorAccount) {
                $putData['account'] = $executorAccount;
                $post->update($putData);
                return '';
            } else {
                return '無權修改';
            }
        }
        return '無此文章';
    }

    public function deletePost($postData, $executorAccount)
    {
        $post = PostEloquent::find($postData['post_id']);
        if ($post) {
            if ($post->account == $executorAccount) {
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