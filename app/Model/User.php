<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Lib\User as UserLib;

class User extends Model
{
  use SoftDeletes;
  # 
  protected $table = 'user';
  
  # The attributes that should be hidden for arrays.
  protected $hidden = [
    'password', 'salt', 'updated_at', 'deleted_at',
  ];


  ########################
  public function save(array $options = []){
    if(!parent::save($options))
      return false;

    // 如果修改的是当前登录用户的信息，得即时更新登录用户信息
    $cur = UserLib::getLoginUser();
    if($cur && $cur->id === $this->id){
      $cur->setModel($this);
    }

    return true;
  }

  public function delete(){
    $this->email .= '@del' . time();
    $this->save();

    return parent::delete();
  }

}
