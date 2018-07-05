<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
  public function session(Request $request){
    dd(session()->all());
  }
}
