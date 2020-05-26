<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Lib\Session;

class DebugController extends Controller
{
    public function __construct(){
        if(!env('APP_DEBUG')){
            abort(403);
        }
    }
  
    public function session(Request $request){
        dd(session()->all());
    }

    public function login(Request $request){
        $uid = $request->uid;

        // $this->abort(\ErrorCode::USER_NOT_EXISTS);

        $um = UserModel::find($uid);
        if(!$um){
            return $this->errorPage(\ErrorCode::USER_NOT_EXISTS);
        }

        Session::setLoginUserID($uid);

        return $this->o($um);
    }
}
