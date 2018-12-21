<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrivateApi extends Model
{
  protected $table = 'private_api';
  protected $primaryKey = 'app';
  public $incrementing = false;
  protected $keyType = 'string';
  public $timestamps = false;

  // 获取api列表
  # => array()
  public function get_apis(){
    if(empty($this->api_list))
      return [];

    $list = explode(',', $this->api_list);
    return $list;
  }

  // 判断api是否存在于api_list
  # => true | false
  public function is_api_exist($api){
    if($this->api_list == 'all'){
      return true;
    }
    
    $list = $this->get_apis();
    return in_array($api, $list);
  }

  // 判断ip是否允许访问
  public function is_ip_allow($ip){
    if(empty($this->ip_allow))
      return false;

    if($this->ip_allow == 'all')
      return true;

    return in_array($ip, explode(',', $this->ip_allow));
  }
}



