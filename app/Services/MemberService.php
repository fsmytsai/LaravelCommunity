<?php
/**
 * Created by PhpStorm.
 * User: tsaiminyuan
 * Date: 2018/1/2
 * Time: 下午4:03
 */

namespace App\Services;

use App\User as UserEloquent;

class MemberService
{
    public function Register($postData)
    {
        $user = new UserEloquent();
        $user->book_name = $postData['book_name'];
        if (isset($post_data['book_picture']))
            $user->book_picture = $postData['book_picture'];
        $user->book_description = $postData['book_description'];
        $user->save();
        return $user->book_id;
    }
}