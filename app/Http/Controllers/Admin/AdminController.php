<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\User as UserEntity;

class AdminController extends Controller {
    public function loginPage(Request $request){
        return 'this is admin login page';
    }

    public function index(Request $request, UserEntity $user){
        return 'this is admin index';
    }
}