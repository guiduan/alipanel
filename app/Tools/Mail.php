<?php
namespace App\Tools;
class Mail
{
    public static function send($to, $subject, $content)
    {
        $url = 'http://api.sendcloud.net/apiv2/mail/send';
        $API_USER = env('SENDCLOUD_API_USER');
        $API_KEY = env('SENDCLOUD_API_KEY');

        //您需要登录SendCloud创建API_USER，使用API_USER和API_KEY才可以进行邮件的发送。
        $param = array(
            'apiUser' => $API_USER,
            'apiKey' => $API_KEY,
            'from' => env('SENDCLOUD_FROM_ADDR'),
            'fromName' => env('SENDCLOUD_FROM_NAME'),
            'to' => $to,
            'subject' => $subject,
            'html' => $content,
            'respEmailId' => 'true');

        $data = http_build_query($param);

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data
            ));

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }
}