<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Lib\User as UserLib;
use App\Entity\User as UserEntity;
use App\Lib\Vericode;

class AdminController extends Controller {
  public function index(Request $request) {
    return redirect('/admin/main');
  }

  public function main(){
    return $this->view('admin/main');
  }

  public function loginPage() {
    return $this->view('user/login');
  }

  public function checkLogin(Request $request) {
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required|string',
      'code' => 'required|string',
    ]);

    if (!Vericode::checkImageVericode($request->code))
      return $this->e(ERROR_VERICODE_ERROR);

    $errorCode = UserLib::checkLogin($request->email, $request->password);
    if(!$errorCode instanceof UserModel)
      return $this->e($errorCode);

    return $this->o();
  }

  public function login(Request $request) {
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required|string',
      'code' => 'required|string',
      'keep' => 'nullable|integer',
    ]);

    if (!Vericode::checkImageVericode($request->code))
      return $this->e(ERROR_VERICODE_ERROR);

    $errorCode = UserLib::checkAndLogin($request->email, $request->password, $request->keep);
    if(!$errorCode instanceof UserModel)
      return $this->e($errorCode);

    Vericode::invalidImageVericode();
    return $this->redirect('adminIndex');
  }

  public function logout(Request $request) {
    UserLib::logout();
    return $this->redirect('adminLogin');
  }

  public function info(Request $request, UserEntity $user) {
    return $this->o([
      'info' => $user,
      'auths' => UserLib::getCharacterAuths($user),
    ]);
  }
}






