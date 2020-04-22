<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\User as UserEntity;

class AdminController extends Controller {
    public function index(Request $request, UserEntity $user){
        return 'this is admin index';
    }   
}