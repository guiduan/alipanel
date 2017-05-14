<?php

/**
 * Created by PhpStorm.
 * User: guiduan
 * Date: 2017/5/10
 * Time: 16:47
 */
namespace app\Tools;
class Hash
{
    public static function passwordHash($str)
    {
        $method = env('PASSWD_METHOD');
        switch ($method) {
            case 'md5':
                return self::md5WithSalt($str);
                break;
            case 'sha256':
                return self::sha256WithSalt($str);
                break;
            default:
                return self::md5WithSalt($str);
        }
        return $str;
    }

    public static function md5WithSalt($pwd)
    {
        $salt = env('PASSWD_SALT');
        return md5($pwd . $salt);
    }

    public static function sha256WithSalt($pwd)
    {
        $salt = env('PASSWD_SALT');
        return hash('sha256', $pwd . $salt);
    }

    // @TODO
    public static function checkPassword($hashedPassword, $password)
    {
        if ($hashedPassword == self::passwordHash($password)) {
            return true;
        }
        return false;
    }
}