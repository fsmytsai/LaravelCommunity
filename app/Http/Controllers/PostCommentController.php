<?php

namespace App\Http\Controllers;

use App\Services\PostCommentService;
use Illuminate\Http\Request;
use Validator;

class PostCommentController extends Controller
{
    public $postCommentService;

    public function __construct()
    {
        $this->postCommentService = new PostCommentService();
    }

    public function getPostComments(Request $request)
    {
        $objValidator = Validator::make(
            $request->all(),
            [
                'post_id' => 'required|integer'
            ],
            [
                'post_id.*' => '錯誤'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $showedPostComIdArr = $request->input('showedPostComIdArr') ?? [];
        $postCommentArr = $this->postCommentService->getPostComments($request->input('post_id'), $showedPostComIdArr);
        return response()->json(['postCommentArr' => $postCommentArr], 200);
    }

    public function createPostComment(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'post_id' => 'required|integer',
                'content' => 'required|max:3000'
            ],
            [
                'post_id.*' => '錯誤',
                'content.required' => '請輸入留言內容',
                'content.max' => '留言內容不可超過 3000 字元'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $postComId = $this->postCommentService->createPostComment($postData);
        if ($postComId == 0)
            return response()->json('新增留言失敗', 400);
        else if ($postComId == -1)
            return response()->json('無此貼文', 400);
        else
            return response()->json($postComId, 200);
    }

    public function updatePostComment(Request $request)
    {
        $putData = $request->all();
        $objValidator = Validator::make(
            $putData,
            [
                'post_com_id' => 'required|integer',
                'content' => 'required|max:3000'
            ],
            [
                'post_com_id.*' => '錯誤',
                'content.required' => '請輸入留言內容',
                'content.max' => '留言內容不可超過 3000 字元'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $resMessage = $this->postCommentService->updatePostComment($putData);
        if ($resMessage == '')
            return response()->json('修改成功', 200);
        else
            return response()->json($resMessage, 400);
    }

    public function deletePostComment(Request $request)
    {
        $deleteData = $request->all();
        $objValidator = Validator::make(
            $deleteData,
            [
                'post_com_id' => 'required|integer'
            ],
            [
                'post_com_id.*' => '錯誤'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $resMessage = $this->postCommentService->deletePostComment($deleteData);
        if ($resMessage == '')
            return response()->json('刪除成功', 200);
        else
            return response()->json($resMessage, 400);
    }
}
