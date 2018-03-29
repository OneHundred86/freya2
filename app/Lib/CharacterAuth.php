<?php
namespace App\Lib;


class CharacterAuth
{
  protected static $map = [
    'addUser'                 => '添加用户',
    'editUser'                => '修改用户',
    'delUser'                 => '删除用户',

    'addUserGroup'            => '添加用户组',
    'editUserGroup'           => '修改用户组',
    'delUserGroup'            => '删除用户组',

    'addCharacter'            => '添加角色',
    'editCharacter'           => '修改角色',
    'delCharacter'            => '删除角色',

    'deployCharAuth'          => '配置角色权限',
  ];

  public function __construct()
  {
    # code...
  }

  public static function all(){
    return self::$map;
  }

  public static function has(string $auth){
    return array_key_exists($auth, self::$map);
  }

}