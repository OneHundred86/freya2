<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\User as UserLib;
use App\Entity\User as UserEntity;
use App\Model\Character as CharacterModel;
use App\Model\CharacterAuth as CharacterAuthModel;
use App\Lib\CharacterAuth as CharacterAuthLib;

class CharacterController extends Controller
{
  public function characterPage(Request $request) {
    return $this->view('admin/character');
  }

  public function lists(Request $request){
    $this->validate($request, [
      'kw'      => 'nullable|string',
      'offset'  => 'required|integer',
      'limit'   => 'required|integer',
    ]);

    $kw = $request->kw;
    $offset = $request->offset;
    $limit = $request->limit;

    $builder = CharacterModel::where('name', 'like', "%$kw%");

    return $this->o([
      'total' => $builder->count(),
      'list' => $builder->offset($offset)->limit($limit)->get(),
    ]);
  }

  public function add(Request $request, UserEntity $user){
    $this->validate($request, [
      'name'        => 'required|string',
    ]);

    $name = $request->name;

    $m = new CharacterModel;
    $m->name = $name;
    $m->save();

    return $this->o([
      'added' => $m,
    ]);
  }

  public function edit(Request $request, UserEntity $user){
    $this->validate($request, [
      'id'          => 'required|integer',
      'name'        => 'required|string',
    ]);

    $m = CharacterModel::find($request->id);
    if(!$m)
      return $this->e('角色信息不存在');

    $name = $request->name;

    $m->name = $name;
    $m->save();

    return $this->o([
      'updated' => $m,
    ]);
  }

  public function del(Request $request, UserEntity $user){
    $this->validate($request, [
      'id'          => 'required|integer',
    ]);

    $m = CharacterModel::find($request->id);
    if(!$m)
      return $this->e('角色信息不存在');

    $m->delete();

    return $this->o([
      'deleted' => $m,
    ]);
  }

  public function allCharacterAuth(Request $request){
    return $this->o([
      'list' => CharacterAuthLib::map(),
    ]);
  }

  public function listCharacterAuth(Request $request){
    $this->validate($request, [
      'id'    => 'required|integer',
    ]);

    $auths = CharacterAuthModel::where('character_id', $request->id)->get();

    $list = [];
    // 删除和过滤不存在的角色权限
    foreach ($auths as $k => $v) {
      if(CharacterAuthLib::has($v->name)){
        $list[] = $v->name;
      }else{
        CharacterAuthModel::where('character_id', $v->character_id)->where('name', $v->name)->delete();
        // $v->delete();
        // $auths->forget($k);
      }
    }

    return $this->o([
      'list' => $list,
    ]);
  }

  public function addCharacterAuth(Request $request, UserEntity $user){
    $this->validate($request, [
      'id'    => 'required|integer',
      'name'  => 'required|string',
    ]);

    $character_id = $request->id;
    $name = $request->name;

    if(!CharacterAuthLib::has($name))
      return $this->e('该权限未定义');

    $auth = CharacterAuthModel::where('character_id', $character_id)->where('name', $name)->first();
    if($auth)
      return $this->e('该角色已存在该权限');

    $m = new CharacterAuthModel;
    $m->character_id = $character_id;
    $m->name = $name;
    $m->save();

    return $this->o();
  }

  public function delCharacterAuth(Request $request, UserEntity $user){
    $this->validate($request, [
      'id'    => 'required|integer',
      'name'  => 'required|string',
    ]);

    $character_id = $request->id;
    $name = $request->name;

    $auth = CharacterAuthModel::where('character_id', $character_id)->where('name', $name)->first();
    if(!$auth)
      return $this->e('该角色不存在该权限');

    CharacterAuthModel::where('character_id', $character_id)->where('name', $name)->delete();

    return $this->o();
  }

  public function getUserAuths(Request $request){
    $this->validate($request, [
      'user_id'   => 'required|integer',
    ]);

    $userID = $request->user_id;
    return $this->o([
      'list' => UserLib::getCharacterAuths($userID),
    ]);
  }
  
}




