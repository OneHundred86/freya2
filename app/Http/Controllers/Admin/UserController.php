<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\User as UserEntity;

class UserController extends Controller
{
    public function info(Request $request, UserEntity $user){
        $info = $user->getModel();
        return $this->o([
            'info' => $info,
        ]);
    }
}
