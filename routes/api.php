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


Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');
Route::post('register', 'UserController@store');
Route::post('refresh-token', 'Auth\AuthController@refreshToken');


Route::group(['middleware' => ['check.auth:api']], function () {
    Route::get('me', 'UserController@me');
    Route::post('update-profile', 'UserController@update');
    Route::get('user/{user_id}', 'UserController@get');
    Route::get('delete-account', 'UserController@delete');
    Route::get('block-user/{block_user_id}', 'UserController@blockUser');
    Route::get('unblock-user/{unblock_user_id}', 'UserController@unblockUser');

    Route::post('follow-user', 'UserController@follow');
    Route::post('unfollow-user', 'UserController@unfollow');
    Route::post('approve-request', 'UserController@approve');
    Route::post('reject-request', 'UserController@reject');
    Route::get('pending-follow-request', 'UserController@followRequest');
    Route::get('search-user', 'UserController@searchUsers');
    Route::get('friends', 'UserController@getFriends');
    Route::get('followings','UserController@getFollowings');
});