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
        'password', 'updated_at', 'deleted_at',
    ];

    // 校验密码
    # => true | false
    public function checkPassword(string $password, int $passwordType = RAW_STRING){
        if($passwordType === RAW_STRING){
            $md5Passwd = md5($password);
            return $this->checkPassword($md5Passwd, MD5_STRING);
        }

        return \Hash::check($password, $this->password);
    }

    // 生成密码
    # => string()
    public static function makePassword(string $password, int $passwordType = RAW_STRING){
        if($passwordType === RAW_STRING){
            $md5Passwd = md5($password);
            return self::makePassword($md5Passwd, MD5_STRING);
        }

        return \Hash::make($password);
    }

}
