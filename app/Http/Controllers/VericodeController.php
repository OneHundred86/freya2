<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Vericode;

class VericodeController extends Controller
{
  public function genImage(){
    return Vericode::genImageVericode();
  }
}
