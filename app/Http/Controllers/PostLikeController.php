<?php

namespace App\Http\Controllers;

use App\Services\PostLikeService;
use Illuminate\Http\Request;
use Validator;

class PostLikeController extends Controller
{
    public $postLikeService;

    public function __construct()
    {
        $this->postLikeService = new PostLikeService();
    }

    public function createPostLike(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'post_id' => 'required|integer'
            ],
            [
                'post_id.*' => '錯誤'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $resMessage = $this->postLikeService->createPostLike($postData);
        if ($resMessage == '')
            return response()->json('成功', 200);
        else
            return response()->json($resMessage, 400);
    }
}
