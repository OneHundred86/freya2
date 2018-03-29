<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CharacterAuth extends Model
{
  //
  protected $table = 'character_auth';
  public $incrementing = false;
  public $timestamps = false;

  # The attributes that should be hidden for arrays.
  protected $hidden = [
  ];
}
