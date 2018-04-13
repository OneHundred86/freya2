<?php
namespace App\Entity;

use App\Model\User as UserModel;

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
}