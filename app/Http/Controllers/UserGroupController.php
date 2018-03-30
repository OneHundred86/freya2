<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserGroup as UserGroupModel;
use App\Lib\User as UserLib;
use App\Model\Character as CharacterModel;

class UserGroupController extends Controller
{
  public function usergroupPage(Request $request) {
    return $this->view('admin/usergroup');
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

    $builder = UserGroupModel::where('name', 'like', "%$kw%");

    return $this->o([
      'total' => $builder->count(),
      'list' => $builder->offset($offset)->limit($limit)->get(),
    ]);
  }

  public function add(Request $request){
    $this->validate($request, [
      'name'        => 'required|string',
    ]);

    if(!UserLib::checkAuth('UserGroup.addUser'))
      return $this->e(-1, '权限不足');

    $name = $request->name;

    $m = new UserGroupModel;
    $m->name = $name;
    $m->characters = json_encode([]);;
    $m->save();

    return $this->o([
      'added' => $m,
    ]);
  }

  public function edit(Request $request){
    $this->validate($request, [
      'id'          => 'required|integer',
      'name'        => 'required|string',
    ]);

    if(!UserLib::checkAuth('UserGroup.edit'))
      return $this->e(-1, '权限不足');

    if($request->id == USERGROUP_ADMIN)
      return $this->e('超级管理员用户组不可修改');

    $m = UserGroupModel::find($request->id);
    if(!$m)
      return $this->e('用户组信息不存在');

    $name = $request->name;

    $m->name = $name;
    $m->save();

    return $this->o([
      'updated' => $m,
    ]);
  }

  public function del(Request $request){
    $this->validate($request, [
      'id'          => 'required|integer',
    ]);

    if(!UserLib::checkAuth('UserGroup.del'))
      return $this->e(-1, '权限不足');

    if($request->id == USERGROUP_ADMIN)
      return $this->e('超级管理员用户组不可删除');

    $m = UserGroupModel::find($request->id);
    if(!$m)
      return $this->e('用户组信息不存在');

    $m->delete();

    return $this->o([
      'deleted' => $m,
    ]);
  }

  public function listCharacter(Request $request){
    $this->validate($request, [
      'id'    => 'required|integer',
    ]);

    $ug = UserGroupModel::find($request->id);
    if(!$ug)
      return $this->e('用户组信息不存在');

    $charIDs = json_decode($ug->characters, true);
    $list = CharacterModel::whereIn('id', $charIDs)->get();

    return $this->o([
      'list' => $list,
    ]);
  }

  public function addCharacter(Request $request){
    $this->validate($request, [
      'id'          => 'required|integer',
      'character'   => 'required|integer',
    ]);

    if(!UserLib::checkAuth('UserGroup.edit'))
      return $this->e(-1, '权限不足');

    if($request->id == USERGROUP_ADMIN)
      return $this->e('超级管理员用户组不可修改');

    $ug = UserGroupModel::find($request->id);
    if(!$ug)
      return $this->e('用户组信息不存在');

    $characterID = $request->character;

    $character = CharacterModel::find($characterID);
    if(!$character)
      return $this->e('角色信息不存在');

    $charIDs = json_decode($ug->characters, true);
    if(in_array($characterID, $charIDs))
      return $this->e('该用户组已存在该角色');

    $charIDs[] = $characterID;
    $characters = json_encode($charIDs);

    $ug->characters = $characters;
    $ug->save();

    $list = CharacterModel::whereIn('id', $charIDs)->get();

    return $this->o([
      'list' => $list,
    ]);
  }

  public function delCharacter(Request $request){
    $this->validate($request, [
      'id'          => 'required|integer',
      'character'   => 'required|integer',
    ]);

    if(!UserLib::checkAuth('UserGroup.edit'))
      return $this->e(-1, '权限不足');

    if($request->id == USERGROUP_ADMIN)
      return $this->e('超级管理员用户组不可修改');

    $ug = UserGroupModel::find($request->id);
    if(!$ug)
      return $this->e('用户组信息不存在');

    $characterID = $request->character;

    $character = CharacterModel::find($characterID);
    if(!$character)
      return $this->e('角色信息不存在');

    $charIDs = json_decode($ug->characters, true);
    if(!in_array($characterID, $charIDs))
      return $this->e('该用户组不存在该角色');

    foreach($charIDs as $k => $v){
      if($v == $characterID)
        // unset($charIDs[$k]);
        array_splice($charIDs, $k, 1); 
    }

    $characters = json_encode($charIDs);

    $ug->characters = $characters;
    $ug->save();

    $list = CharacterModel::whereIn('id', $charIDs)->get();

    return $this->o([
      'list' => $list,
    ]);
  }

}





