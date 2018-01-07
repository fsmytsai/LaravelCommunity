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
    public function getPost($postId)
    {
        return PostEloquent::find($postId)
            ->withData();
    }

    public function getPosts($showedPostIdArr)
    {
        $postArr = PostEloquent::whereNotIn('post_id', $showedPostIdArr)
            ->orderByDesc('new_com_time')
            ->take(15)
            ->withData()
            ->get();

        return $postArr;
    }

    public function getUserAllPosts($userAccount)
    {
        return PostEloquent::where('account', $userAccount)
            ->orderByDesc('post_id')
            ->withData()
            ->get();
    }

    public function createPost($postData)
    {
        $post = PostEloquent::create($postData);
        return $post->post_id;
    }

    public function updatePost($putData)
    {
        $post = PostEloquent::find($putData['post_id']);
        if ($post) {
            if ($post->account == $putData['account']) {
                $post->content = $putData['content'];
                $post->update_post_time = \Carbon\Carbon::now();
                $post->save();
                return '';
            } else {
                return '無權修改';
            }
        }
        return '無此貼文';
    }

    public function deletePost($deleteData)
    {
        $post = PostEloquent::find($deleteData['post_id']);
        if ($post) {
            if ($post->account == $deleteData['account']) {
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
        return '無此貼文';
    }
}