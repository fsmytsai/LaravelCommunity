<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(Request $request)
    {
        $postData = $request->all();
        $objValidator = Validator::make(
            $postData,
            [
                'account' => [
                    'required',
                    'between:6,20',
                    'regex:/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i',
                    'unique:users'
                ],
                'password' => [
                    'required',
                    'between:6,20',
                    'regex:/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i'
                ],
                'name' => 'required|max:20',
                'email' => 'required|email|max:50'
            ],
            [
                'account.required' => '請輸入帳號',
                'account.between' => '帳號需介於6-20字元',
                'account.regex' => '帳號需包含英文數字',
                'account.unique' => '帳號已存在',
                'password.required' => '請輸入密碼',
                'password.between' => '密碼需介於 6-20 字元',
                'password.regex' => '密碼需包含英文數字',
                'name.required' => '請輸入姓名',
                'name.max' => '姓名不可超過 20 字元',
                'email.required' => '請輸入信箱',
                'email.email' => '信箱格式錯誤',
                'email.max' => '信箱不可超過 50 字元'
            ]
        );

        if ($objValidator->fails())
            return response()->json($objValidator->errors()->all(), 400);

        $this->userService->register($postData);
        return response()->json('註冊成功', 200);
    }

    public function login(Request $request)
    {
        $postData = $request->only('account', 'password');
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

        $resMessage = $this->userService->login($postData);
        if ($resMessage != '')
            return response()->json([$resMessage], 400);

        return response()->json('bearer ' . Auth::guard()->attempt($postData), 200);
    }

    public function getUserData()
    {
        return response()->json(Auth::guard()->user(), 200);
//        return response()->json(JWTAuth::decode(JWTAuth::getToken())->toArray()); 取得 claims
    }

    public function logout()
    {
        Auth::guard()->logout();
        return response()->json('登出成功', 200);
    }
}
