<?php
/**
 * Created by PhpStorm.
 * User: tsaiminyuan
 * Date: 2018/1/2
 * Time: 下午4:03
 */

namespace App\Services;

use App\User as UserEloquent;
use Hash;

class UserService
{
    public function login($postData)
    {
        $user = UserEloquent::find($postData['account']);
        if ($user) {
            if (Hash::check($postData['password'], $user->password)) {
                return '';
            }
            return '密碼錯誤';
        }
        return '無此帳號請去註冊';
    }

    public function register($postData)
    {
        $postData['password'] = bcrypt($postData['password']);
        UserEloquent::create($postData);
    }
}