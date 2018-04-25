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


class QuestionController extends Controller
{
  public function getChoice()
  {
    try {
     
        // $user = DB::select("select name,phone,email,department,isSuperAdmin from laravel_manage_user limit {$dataStart},{$size}");
        $user = DB::table('choice_question')
        ->get();
        $count = DB::table('choice_question')
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
  public function getBlanks()
  {
    try {
     
        // $user = DB::select("select name,phone,email,department,isSuperAdmin from laravel_manage_user limit {$dataStart},{$size}");
        $user = DB::table('blanks_question')
        ->get();
        $count = DB::table('blanks_question')
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
  public function addQuestion (Request $request) {
    $action = $request->input('action');
    if($action == 'addChoice') {
      $question = $request->input('question');
      $score = $request->input('score');
      $choiceA = $request->input('choiceA');
      $choiceB = $request->input('choiceB');
      $choiceC = $request->input('choiceC');
      $choiceD = $request->input('choiceD');
      $right_answer = $request->input('right_answer');
      $addChoice = DB::table('choice_question')->insert(
        ['question' => $question, 'score' => $score, 'choiceA' => $choiceA, 'choiceB' => $choiceB,
         'choiceC' => $choiceC, 'choiceD' => $choiceD, 'right_answer' => $right_answer]
      );
      if($addChoice) {
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
    } else if($action == 'addBlanks') {
      $question = $request->input('question');
      $score = $request->input('score');
      $right_answer = $request->input('right_answer');
      $addBlanks = DB::table('blanks_question')->insert(
        ['question' => $question, 'score' => $score, 'right_answer' => $right_answer]
      );
      if($addBlanks) {
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
  public function delQuestion (Request $request) {
    $action = $request->input('action');
    $id = $request->input('id');
    if($action == 'delChoice') {
      $delQuestion = DB::delete('delete from choice_question where id = ?',[$id]);
    } else if($action == 'delBlanks') {
      $delQuestion = DB::delete('delete from blanks_question where id = ?',[$id]);
    }
    if($delQuestion) {
      $response = [
        'message' => '删除成功',
        'status' => 200
      ];
      return Response::json($response);
    } else {
      $response = [
        'message' => '删除失败',
        'status' => 401
      ];
      return Response::json($response);
    }
  }



}