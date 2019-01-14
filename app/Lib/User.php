<?php

namespace App\Lib;

use App\Model\User as UserModel;
use App\Entity\User as UserEntity;
use App\Model\UserGroup as UserGroupModel;
use App\Model\Character as CharacterModel;
use App\Model\CharacterAuth as CharacterAuthModel;
use App\Lib\CharacterAuth as CharacterAuthLib;
use App\Lib\Util;
use Illuminate\Support\Facades\Cookie;


class User
{
  // 获取当前登录的用户信息
  # => false | UserEntity
  static public function getLoginUser(){
    $ue = app()->make(UserEntity::class);
    
    if(empty($ue->id)){
      $user_id = Session::getLoginUserID();
      if($user_id){ // 从session中获取用户信息
        $um = UserModel::find($user_id);
      }else{ // 从cookie中获取用户信息
        $um = self::getUserFromCookie();
      }

      if(!$um){
        return false;
      }else{
        $ue->setModel($um);
      }
    }

    return $ue;
  }

  // => false | UserModel
  private static function getUserFromCookie(){
    $uid = Cookie::get(Util::cookieTag('uid'));
    $uid = intval($uid);
    if(empty($uid))
      return false;

    $time = Cookie::get(Util::cookieTag('time'));
    $time = intval($time);
    if(empty($time)){
      return false;
    }elseif(time() - $time > 86400*30){
      return false;
    }

    $snap = Cookie::get(Util::cookieTag('snap'));
    if(empty($snap))
      return false;

    $user = UserModel::find($uid);
    if(!$user)
      return false;

    if($snap != self::makeSnap($user->password, $user->salt, $time))
      return false;

    Session::setLoginUserID($user->id);

    return $user;
  }

  # => int | UserModel
  static public function checkLogin($email, $password){
    $user = UserModel::where('email', $email)->first();
    if(empty($user)){
      return ERROR_USER_NOT_EXISTS;
    }elseif($user->ban === USER_BANED){
      return ERROR_USER_BANED;
    }

    $password1 = self::makePassword($password, $user->salt, MD5_STRING);
    if($user->password != $password1)
      return ERROR_PASSWORD_ERROR;

    return $user;
  }

  // 检验并且登录
  # => int | UserModel
  static public function checkAndLogin($email, $password, $keep = false){
    $user = self::checkLogin($email, $password);
    if(!$user instanceof UserModel)
      return $user;

    Session::setLoginUserID($user->id);

    $path = url('admin');
    if($keep){
      $time = time();
      $minutes = 60 * 24 * 30;

      Cookie::queue(Util::cookieTag('uid'), $user->id, $minutes, $path);
      Cookie::queue(Util::cookieTag('time'), $time, $minutes, $path);
      Cookie::queue(Util::cookieTag('snap'), self::makeSnap($user->password, $user->salt, $time), $minutes, $path);
    }else{
      Cookie::queue(Util::cookieTag('uid'), null, -1, $path);
      Cookie::queue(Util::cookieTag('time'), null, -1, $path);
      Cookie::queue(Util::cookieTag('snap'), null, -1, $path);
    }

    return $user;
  }

  // 登出
  static public function logout(){
    Session::flush();
  }

  # => string()
  static public function makePassword($password, $salt, $passwordType = RAW_STRING){
    if($passwordType === RAW_STRING){
      $md5Passwd = md5($password);
      return self::makePassword($md5Passwd, $salt, MD5_STRING);
    }
    
    return md5($password . $salt);
  }

  static public function makeSnap($password, $salt, $time){
    return md5($salt.md5($time.md5($password)));
  }

  # => false | UserModel
  static public function add($email, $password, $passwordType = RAW_STRING, $group = 0){
    # 邮件帐号已存在
    if(UserModel::where('email', $email)->first())
      return false;

    $salt = rand(10000000, 99999999);
    $model = new UserModel;
    $model->email = $email;
    $model->password = self::makePassword($password, $salt, $passwordType);
    $model->salt = $salt;
    $model->group = $group;
    $model->save();
    return $model;
  }

  // 获取用户的所有角色权限
  # $user = integer | UserEntity
  # => false | [string()]
  public static function getCharacterAuths($user){
    if(!$user instanceof UserEntity){
      $um = UserModel::find($user);
      if(!$um)
        return false;

      $user = new UserEntity;
      $user->setModel($um);
    }

    if($user->group === USERGROUP_ADMIN){
      $auths = CharacterAuthLib::all();
    }else{
      $userGroup = UserGroupModel::find($user->group);
      if(!$userGroup)
        return false;

      $characters = json_decode($userGroup->characters, true);

      $characterAuths = CharacterAuthModel::whereIn('character_id', $characters)->get();

      $auths = [];
      foreach($characterAuths as $v){
        $auths[$v->name] = true;
      }
    }

    return array_keys($auths);
  }

  // 判断用户是否有指定角色权限
  # $user = integer | UserEntity
  # $auth = sprintf('%s.%s', $module, $authKey);
  # => true | false
  public static function checkCharacterAuth($user, string $auth){
    if(!$user instanceof UserEntity){
      $um = UserModel::find($user);
      if(!$um)
        return false;

      $user = new UserEntity;
      $user->setModel($um);
    }

    // 特殊指定，超级管理员的用户组为1
    if($user->group === USERGROUP_ADMIN)
      return true;

    $auths = self::getCharacterAuths($user);

    if(!$auths)
      return false;

    return in_array($auth, $auths);
  }
}



