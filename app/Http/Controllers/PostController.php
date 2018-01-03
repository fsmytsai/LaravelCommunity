<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use Auth;
use Validator;

class PostController extends Controller
{
    public $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }

    public function getPosts(Request $request)
    {
        $showedPostIdArr = $request->input('showedPostIdArr') ?? [];
        $postArr = $this->postService->getPosts($showedPostIdArr);
        return response()->json(['postArr' => $postArr], 200);
    }

    public function getUserAllPosts()
    {
        $executorAccount = Auth::guard()->user()['account'];
        $data = $this->postService->getUserAllPosts($executorAccount);
        return response()->json($data, 200);
    }

    public function createPost(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'content' => 'required|max:3000'
            ],
            [
                'content.required' => '請輸入文章內容',
                'content.max' => '文章內容不可超過 3000 字元'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $executorAccount = Auth::guard()->user()['account'];
        $post_id = $this->postService->CreatePost($postData, $executorAccount);
        if ($post_id != 0)
            return response()->json($post_id, 200);
        else
            return response()->json('新增貼文失敗', 400);
    }

    public function updatePost(Request $request)
    {
        $putData = $request->all();
        $objValidator = Validator::make(
            $putData,
            [
                'post_id' => 'required|integer',
                'content' => 'required|max:3000'
            ],
            [
                'post_id.*' => '錯誤',
                'content.required' => '請輸入文章內容',
                'content.max' => '文章內容不可超過 3000 字元'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $executorAccount = Auth::guard()->user()['account'];
        $resMessage = $this->postService->updatePost($putData, $executorAccount);
        if ($resMessage == '')
            return response()->json('修改成功', 200);
        else
            return response()->json($resMessage, 400);
    }

    public function deletePost(Request $request)
    {
        $deleteData = $request->all();
        $objValidator = Validator::make(
            $deleteData,
            [
                'post_id' => 'required|integer'
            ],
            [
                'post_id.*' => '錯誤'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $executorAccount = Auth::guard()->user()['account'];
        $resMessage = $this->postService->deletePost($deleteData, $executorAccount);
        if ($resMessage == '')
            return response()->json('刪除成功', 200);
        else
            return response()->json($resMessage, 400);
    }
}
