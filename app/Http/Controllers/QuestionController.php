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
  public function getQuestion()
  {
    try {
     
        // $user = DB::select("select name,phone,email,department,isSuperAdmin from laravel_manage_user limit {$dataStart},{$size}");
        $user = DB::table('question')
        ->get();
        $count = DB::table('question')
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



}