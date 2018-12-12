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
    'password' => 'xxx',
    'charset' => 'utf-8'
];
$mail = new Mail($config);
$options = [
    'to' => ['xxx@xxx.com','xxx@xxx.com'],
    'subject' => 'test',
    'body' => '这是一封测试邮件',
    'attachment' => [
        '/Users/xxx/Downloads/xxx.jpg'
    ]
];
$ret = $mail->send($options);
var_dump($ret);
var_dump($mail->error_info);