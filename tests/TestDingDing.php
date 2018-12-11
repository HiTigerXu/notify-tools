<?php
/**
 * Created by PhpStorm.
 * User: tiger
 * Date: 2018/12/11
 * Time: 下午5:56
 */

require_once '../vendor/autoload.php';
use NotifyTools\DingDing;

$config = [
    'token' => 'xxx'
];
$mail = new DingDing($config);
$options = [
    'content' => 'just a test message',
];
$ret = $mail->send($options);
var_dump($ret);
var_dump($mail->error_info);