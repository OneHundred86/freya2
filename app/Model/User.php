<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
  use SoftDeletes;
  # 
  protected $table = 'user';
  
  # The attributes that should be hidden for arrays.
  protected $hidden = [
    'password', 'salt', 'updated_at', 'deleted_at',
  ];

}
