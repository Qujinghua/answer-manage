<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
// use Dingo\Api\Routing\Helpers;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
  // use Helpers;
  public function userRegister (Request $request) {
    $name = $request->input('username');
    $pwd = $request->input('pwd');
    $action = $request->input('action');
    if($action == 'add') {
      $addUser = DB::table('users')->insert(
        ['name' => $name, 'pwd' => $pwd]
      );
      if($addUser) {
        $response = [
          'message' => '新增成功',
          'status' => 200
        ];
        return Response::json($response);
      } else {
        $response = [
          'message' => '新增失败',
          'status' => 401
        ];
        return Response::json($response);
      }
    } else if($action == 'edit') {
      $id = $request->input('id');
      $updateUser = DB::update('update laravel_manage_user set name = ?, phone = ?, email = ?,department = ?,isSuperAdmin = ? where id = ?',
      [$name, $phone, $email, $department, $isSuperAdmin, $id]);
      if($updateUser) {
        $response = [
          'message' => '编辑成功',
          'status' => 200
        ];
        return Response::json($response);
      } else {
        $response = [
          'message' => '编辑失败',
          'status' => 401
        ];
        return Response::json($response);
      }
      
    }
    
  }
  public function getUser()
  {
    try {
     
        // $user = DB::select("select name,phone,email,department,isSuperAdmin from laravel_manage_user limit {$dataStart},{$size}");
        $user = DB::table('users')
        // ->select('id','name','phone','email','department','isSuperAdmin')
        // ->where('name', 'like', '%'.$keyword.'%')
        // ->orWhere('department', 'like', '%'.$keyword.'%')
        // ->offset($dataStart)
        // ->limit($size)
        ->get();
        $count = DB::table('users')
        // ->select('id','name','phone','email','department','isSuperAdmin')
        // ->where('name', 'like', '%'.$keyword.'%')
        // ->orWhere('department', 'like', '%'.$keyword.'%')
        ->count();
      
      $response = [
        'data' => $user,
        'total' => $count
      ];
      return Response::json($response);
    } catch (Exception $e) {
        report($e);
        return false;
    }

  }

  public function userLogin(Request $request)
  {
    $name = $request->input('username');
    $pwd = $request->input('pwd');
    $isUser = DB::table('users')
    ->where('name', $name)
    ->get();
    $isUser = json_decode($isUser, true);
    if (count($isUser)) {
      $isPwd = $isUser[0]["pwd"];
      if ($isPwd==$pwd) {
        $loginResponse = [
          'message' => '登录成功！',
          'username' => $isUser[0]["name"],
          'isSuper' => $isUser[0]["isSuper"],
          'userid' => $isUser[0]["id"],
          'status' => 200
        ];
        // Session::put('username',$username);
        // Session::put('id',$isUser[0]["id"]);  
        // Session::save();  
        return Response::json($loginResponse);
      } else {
        $loginResponse = [
          'message' => '密码错误！',
          'status' => 401
        ];
        return Response::json($loginResponse);
      }
    } else {
      $Response = [
        'message' => '用户名错误！',
        'status' => 401
      ];
      return Response::json($Response);
    }
    
  }



}