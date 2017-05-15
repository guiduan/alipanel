<?php
/**
 * Created by PhpStorm.
 * User: guiduan
 * Date: 2017/5/15
 * Time: 13:39
 */

namespace App\Tools;


class Tool
{
    public static function genRandomChar($len = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $char = '';
        for ($i = 0; $i < $len; $i++) {
            $char .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $char;
    }
}