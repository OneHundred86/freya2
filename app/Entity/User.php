<?php
namespace App\Entity;

use App\Model\User as UserModel;
use App\Lib\User as UserLib;

/**
* 当前登录的用户实体
*/
class User extends EntityBase
{
  # $user :: int | UserModel
  public function __construct($user = null){
    if(is_integer($user)){
      $um = UserModel::find($user);
      if(!$um)
        throw new \Exception("用户信息不存在", 1);
      
      $this->setModel($um);
    }elseif($user instanceof UserModel){
      $this->setModel($user);
    }
  }

  // 判断用户是否有指定角色权限
  # $auth = sprintf('%s.%s', $module, $authKey);
  # => true | false
  public function checkAuth(string $auth){
    return UserLib::checkCharacterAuth($this, $auth);
  }

}


