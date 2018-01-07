<?php
/**
 * Created by PhpStorm.
 * User: tsaiminyuan
 * Date: 2018/1/6
 * Time: 下午4:08
 */

namespace App\Services;

use App\PostComment as PostCommentEloquent;
use DB;

class PostCommentService
{
    public function getPostComments($postId, $showedPostComIdArr)
    {
        $postCommentArr = PostCommentEloquent::where('post_id', $postId)
            ->whereNotIn('post_com_id', $showedPostComIdArr)
            ->orderByDesc('created_at')
            ->take(15)
            ->with(['user' => function ($query) {
                $query->select(['account', 'name', 'profile_pic']);
            }])
            ->get();

        return $postCommentArr;
    }

    public function createPostComment($postData)
    {
        $post = \App\Post::find($postData['post_id']);
        if (!$post)
            return -1;//無此貼文

        $post->new_com_time = \Carbon\Carbon::now();
        $postComment = null;
        try {
            DB::transaction(function () use ($postData, $post, &$postComment) {
                $post->save();
                $postComment = PostCommentEloquent::create($postData);
            });
            return $postComment->post_com_id;
        } catch (\Exception $e) {
            return 0;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public function updatePostComment($putData)
    {
        $postComment = PostCommentEloquent::find($putData['post_com_id']);
        if ($postComment) {
            if ($postComment->account == $putData['account']) {
                $postComment->update($putData);
                return '';
            } else {
                return '無權修改';
            }
        }
        return '無此留言';
    }

    public function deletePostComment($deleteData)
    {
        $postComment = PostCommentEloquent::find($deleteData['post_com_id']);
        if ($postComment) {
            if ($postComment->account == $deleteData['account']) {
                try {
                    $postComment->delete();
                } catch (\Exception $ex) {
                    return '刪除失敗';
                }
                return '';
            } else {
                return '無權刪除';
            }
        }
        return '無此留言';
    }
}