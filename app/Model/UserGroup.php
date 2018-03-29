<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends Model
{
  use SoftDeletes;
  # 
  protected $table = 'user_group';
  
  # The attributes that should be hidden for arrays.
  protected $hidden = [
    'characters', 'deleted_at'
  ];


  ########################
  public function save(array $options = []){
    !isset($this->characters) && $this->characters = '';
    return parent::save();
  }
}
