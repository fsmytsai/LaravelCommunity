<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class MemberController extends Controller
{
    public function login(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'account' => 'required',
                'password' => 'required'
            ],
            [
                'account.required' => '請輸入帳號',
                'password.required' => '請輸入密碼'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $credentials = $request->only('account', 'password');
        $token = Auth::guard('api')->attempt($credentials);
        if ($token)
            return response()->json('bearer ' . $token, 200);
        return response()->json("登入失敗", 401);
    }

    public function register(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'account' => 'required',
                'password' => 'required',
                'email' => 'required'
            ],
            [
                'account.required' => '請輸入帳號',
                'password.required' => '請輸入密碼',
                'email.required' => '請輸入信箱'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $credentials = $request->only('account', 'password');
        $token = Auth::guard('api')->attempt($credentials);
        if ($token)
            return response()->json('bearer ' . $token, 200);
        return response()->json("登入失敗", 401);
    }
}
