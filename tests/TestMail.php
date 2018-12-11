<?php
/**
 * Created by PhpStorm.
 * User: tiger
 * Date: 2018/12/11
 * Time: 下午12:52
 */
require_once '../vendor/autoload.php';

use NotifyTools\Mail;

$config = [
    'host' => 'ssl://smtp.exmail.qq.com',
    'port' => 465,
    'username' => 'xxx@xxx.com',
    'password' => 'xxxxxx'
];
$mail = new Mail($config);
$options = [
    'to' => ['xxx@xxx.com'],
    'subject' => 'test',
    'body' => 'just a test mail',
    'attachment' => [
        '/Users/xxx/Downloads/xxx.jpg'
    ]
];
$ret = $mail->send($options);
var_dump($ret);
var_dump($mail->error_info);