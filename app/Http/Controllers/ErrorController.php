<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller {
	public function noauth(Request $request) {
		return $this->view('error/error', ['error_msg' => '抱歉，您没有访问此页面的权限']);
	}

}






