<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Lib\User as UserLib;
use App\Lib\Vericode;

class UserController extends Controller {
	public function index(Request $request) {
		return $this->view('admin/main');
	}

	public function userPage(Request $request) {
		return $this->view('admin/user');
	}

	public function loginPage() {
		return $this->view('user/login');
	}

	public function accountSettingPage() {
		return $this->view('admin/accountSetting');
	}

	public function checkLogin(Request $request) {
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|string',
			'code' => 'required|string',
		]);

		if (!Vericode::checkImageVericode($request->code))
			return $this->e('验证码错误');

		$errorCode = UserLib::checkLogin($request->email, $request->password);
		if($errorCode === ERROR_USER_NO_EXIST)
			return $this->e('用户不存在');
		elseif($errorCode === ERROR_USER_BANED)
			return $this->e('帐号已被封号，请联系管理员');
		elseif($errorCode === ERROR_PASSWORD_ERROR)
			return $this->e('密码错误');

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
			return $this->e(1, '验证码错误');

		if (!UserLib::checkAndLogin($request->email, $request->password, $request->keep)) {
			return $this->e(2, '帐号不存在，或者密码错误');
		}
		Vericode::invalidImageVericode();
		return redirect('/admin/');
	}

	public function logout(Request $request) {
		UserLib::logout();
		return redirect()->route('adminLogin');
	}

	public function info(Request $request) {
		$user = UserLib::getLoginUser();
		return $this->o($user);
	}

	public function lists(Request $request){
		$this->validate($request, [
			'group'		=> 'nullable|integer',
			'kw'			=> 'nullable|string',
			'offset'	=> 'required|integer',
			'limit'		=> 'required|integer',
		]);

		$group = $request->group;
		$kw = $request->kw;
		$offset = $request->offset;
		$limit = $request->limit;

		if($group)
			$builder = UserModel::where('group', $group);
		else
			$builder = new UserModel;

		$builder->where('email', 'like', "%$kw%");

		return $this->o([
			'total' => $builder->count(),
			'list' => $builder->offset($offset)->limit($limit)->get(),
		]);
	}

	public function add(Request $request){
		$this->validate($request, [
			'email'			=> 'required|email',
			'password'	=> 'required|string',
			'group'			=> 'required|integer',
		]);

		if(!UserLib::checkAuth('addUser'))
			return $this->e(-1, '权限不足');

		$email = $request->email;
		$password = $request->password;
		$group = $request->group;

		$m = UserLib::add($email, $password, MD5_STRING, $group);

		return $this->o([
			'added' => $m,
		]);
	}

	public function edit(Request $request){
		$this->validate($request, [
			'id'				=> 'required|integer',
			// 'email'			=> 'required|email',
			'password'	=> 'required|string',
			'group'			=> 'required|integer',
		]);

		if(!UserLib::checkAuth('editUser'))
			return $this->e(-1, '权限不足');

		$email = $request->email;
		$password = $request->password;
		$group = $request->group;

		$m = UserModel::find($request->id);
		if(!$m)
			return $this->e('用户信息不存在');

		// $m->email = $email;
		$m->password = UserLib::makePassword($password, $m->salt, MD5_STRING);
		$m->group = $group;
		$m->save();

		return $this->o([
			'updated' => $m,
		]);
	}

	public function del(Request $request){
		$this->validate($request, [
			'id'				=> 'required|integer',
		]);

		if(!UserLib::checkAuth('delUser'))
			return $this->e(-1, '权限不足');

		$m = UserModel::find($request->id);
		if(!$m)
			return $this->e('用户信息不存在');

		$m->delete();

		return $this->o([
			'deleted' => $m,
		]);
	}

	public function changeGroup(Request $request){
		$this->validate($request, [
			'id'			=> 'required|integer',
			'group'		=> 'required|integer',
		]);

		if(!UserLib::checkAuth('editUser'))
			return $this->e(-1, '权限不足');

		$m = UserModel::find($request->id);
		if(!$m)
			return $this->e('用户信息不存在');

		$m->group = $request->group;
		$m->save();

		return $this->o([
			'updated' => $m,
		]);
	}

	public function ban(Request $request){
		$this->validate($request, [
			'id'			=> 'required|integer',
			'ban'			=> 'required|integer',
		]);

		if(!UserLib::checkAuth('editUser'))
			return $this->e(-1, '权限不足');

		$m = UserModel::find($request->id);
		if(!$m)
			return $this->e('用户信息不存在');

		$m->ban = $request->ban;
		$m->save();

		return $this->o([
			'updated' => $m,
		]);
	}

	public function modifyPassword(Request $request){
		$this->validate($request, [
			'old'			=> 'required|string',
			'new'			=> 'required|string',
		]);

		$old = $request->old;
		$new = $request->new;

		$user = UserLib::getLoginUser();
		if($user->password != UserLib::makePassword($old, $user->salt, MD5_STRING))
			return $this->e('原密码错误');

		$user->password = UserLib::makePassword($new, $user->salt, MD5_STRING);
		$user->save();

		return $this->o([
			'updated' => $user,
		]);
	}

}






