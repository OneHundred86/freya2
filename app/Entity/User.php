<?php
namespace App\Entity;

use App\Model\User as UserModel;

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

}


