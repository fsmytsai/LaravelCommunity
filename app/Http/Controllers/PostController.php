<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
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

    public function getUserAllPosts(Request $request)
    {
        $postArr = $this->postService->getUserAllPosts($request->input('account'));
        return response()->json(['postArr' => $postArr], 200);
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
                'content.required' => '請輸入貼文內容',
                'content.max' => '貼文內容不可超過 3000 字元'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $postId = $this->postService->createPost($postData);
        if ($postId != 0)
            return response()->json($postId, 200);
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
                'content.required' => '請輸入貼文內容',
                'content.max' => '貼文內容不可超過 3000 字元'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $resMessage = $this->postService->updatePost($putData);
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

        $resMessage = $this->postService->deletePost($deleteData);
        if ($resMessage == '')
            return response()->json('刪除成功', 200);
        else
            return response()->json($resMessage, 400);
    }
}
