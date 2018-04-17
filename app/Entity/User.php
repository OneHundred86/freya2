<?php
namespace App\Entity;

use App\Model\User as UserModel;
use App\Lib\User as UserLib;

/**
* 当前登录的用户实体
*/
class User extends UserModel
{
  public $exists = true;
  
  public function __construct(){
  }

  public function setModel(UserModel $user){
    $this->id = $user->id;
    $this->email = $user->email;
    $this->password = $user->password;
    $this->salt = $user->salt;
    $this->group = $user->group;
    $this->ban = $user->ban;
  }

  // 判断用户是否有指定角色权限
  # $auth = sprintf('%s.%s', $module, $authKey);
  # => true | false
  public function checkAuth(string $auth){
    return UserLib::checkCharacterAuth($this, $auth);
  }

}


