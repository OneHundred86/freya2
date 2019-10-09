<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
  public function __construct(){
    if(!env('APP_DEBUG')){
      abort(403);
    }
  }
  
  public function session(Request $request){
    // abort(404, '这是自定义错误提示');
    dd(session()->all());
  }
}
