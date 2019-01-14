<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Lib\User as UserLib;
use App\Entity\User as UserEntity;
use App\Lib\Vericode;

class UserController extends Controller {
	public function userPage(Request $request) {
		return $this->view('admin/user');
	}

	public function accountSettingPage() {
		return $this->view('admin/accountSetting');
	}

	public function info(Request $request, UserEntity $user) {
		return $this->o([
			'info' => $user,
			'auths' => UserLib::getCharacterAuths($user),
		]);
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

		$builder = UserModel::query();

		if($group)
			$builder = UserModel::where('group', $group);

		if($kw)
			$builder->where('email', 'like', "%$kw%");

		return $this->o([
			'total' => $builder->count(),
			'list' => $builder->offset($offset)->limit($limit)->get(),
		]);
	}

	public function add(Request $request, UserEntity $user){
		$this->validate($request, [
			'email'			=> 'required|email',
			'password'	=> 'required|string',
			'group'			=> 'required|integer',
		]);

		$email = $request->email;
		$password = $request->password;
		$group = $request->group;

		$m = UserLib::add($email, $password, MD5_STRING, $group);

		return $this->o([
			'added' => $m,
		]);
	}

	public function edit(Request $request, UserEntity $user){
		$this->validate($request, [
			'id'				=> 'required|integer',
			// 'email'			=> 'required|email',
			'password'	=> 'required|string',
			'group'			=> 'required|integer',
		]);

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

	public function del(Request $request, UserEntity $user){
		$this->validate($request, [
			'id'				=> 'required|integer',
		]);

		$m = UserModel::find($request->id);
		if(!$m)
			return $this->e('用户信息不存在');

		$m->delete();

		return $this->o([
			'deleted' => $m,
		]);
	}

	public function changeGroup(Request $request, UserEntity $user){
		$this->validate($request, [
			'id'			=> 'required|integer',
			'group'		=> 'required|integer',
		]);

		$m = UserModel::find($request->id);
		if(!$m)
			return $this->e('用户信息不存在');

		$m->group = $request->group;
		$m->save();

		return $this->o([
			'updated' => $m,
		]);
	}

	public function ban(Request $request, UserEntity $user){
		$this->validate($request, [
			'id'			=> 'required|integer',
			'ban'			=> 'required|integer',
		]);

		$m = UserModel::find($request->id);
		if(!$m)
			return $this->e('用户信息不存在');

		$m->ban = $request->ban;
		$m->save();

		return $this->o([
			'updated' => $m,
		]);
	}

	public function modifyPassword(Request $request, UserEntity $user){
		$this->validate($request, [
			'old'			=> 'required|string',
			'new'			=> 'required|string',
		]);

		$old = $request->old;
		$new = $request->new;

		if($user->password != UserLib::makePassword($old, $user->salt, MD5_STRING))
			return $this->e('原密码错误');

		$user->password = UserLib::makePassword($new, $user->salt, MD5_STRING);
		$user->save();

		return $this->o([
			'updated' => $user,
		]);
	}

}






