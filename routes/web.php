<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::any('/config/getUser', 'UserController@getUser');
Route::any('/config/userRegister', 'UserController@userRegister');//注册
Route::any('/config/userLogin', 'UserController@userLogin');//登录
Route::any('/config/getQuestion', 'QuestionController@getQuestion');//获得题目

