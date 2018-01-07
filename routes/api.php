<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'jwt_auth'], function () {
    Route::get('getUserData', 'UserController@getUserData');
    Route::get('logout', 'UserController@logout');

    Route::get('getPosts', 'PostController@getPosts');
    Route::get('getUserAllPosts', 'PostController@getUserAllPosts');
    Route::post('createPost', 'PostController@createPost');
    Route::put('updatePost', 'PostController@updatePost');
    Route::delete('deletePost', 'PostController@deletePost');

    Route::get('getPostComments', 'PostCommentController@getPostComments');
    Route::post('createPostComment', 'PostCommentController@createPostComment');
    Route::put('updatePostComment', 'PostCommentController@updatePostComment');
    Route::delete('deletePostComment', 'PostCommentController@deletePostComment');

    Route::post('createPostLike', 'PostLikeController@createPostLike');
});