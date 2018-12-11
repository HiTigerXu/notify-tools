<?php

namespace NotifyTools;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Created by PhpStorm.
 * User: tiger
 * Date: 2018/12/11
 * Time: 下午12:31
 */
class Mail extends Base
{

    public function __construct(array $config)
    {
        $_config = [
            'host' => 'xxx',
            'port' => 465,
            'username' => 'xxx',
            'password' => 'xxx',
            'smtp_debug' => 0,
            'smtp_auth' => true,
            'smtp_secure' => 'ssl',
            'smtp_options' => [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]
        ];

        $this->config = array_merge($_config, $config);
    }

    public function send(array $options)
    {
        if(empty($options['to']) || empty($options['subject']) || empty($options['body'])) {
            $this->error_info = '发送失败：缺少必传参数';
            return false;
        }

        try {
            $mail = $this->mailInit();
            //Recipients
            $mail->setFrom($mail->Username);
            foreach ($options['to'] as $touser) {
                $mail->addAddress($touser);     // Add a recipient
            }
            //$mail->addReplyTo('info@example.com', 'Information');
            if(!empty($options['cc'])) {
                foreach ($options['cc'] as $cc) {
                    $mail->addCC($cc);
                }
            }
            if(!empty($options['attachment'])) {
                foreach ($options['attachment'] as $attachment) {
                    $mail->addAttachment($attachment);
                }
            }

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $options['subject'];
            $mail->Body    = $options['body'];
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            if(!$mail->send()) {
                $this->error_info = '发送失败：' . $mail->ErrorInfo;
                return false;
            }
        } catch (Exception $exception) {
            $this->error_info = '发送失败：' . $exception->getMessage();
            return false;
        }
        return true;
    }

    private function mailInit()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = $this->config['smtp_debug'];
        $mail->Host = $this->config['host'];
        $mail->Port = $this->config['port'];
        $mail->Username = $this->config['username'];                 // SMTP username
        $mail->Password = $this->config['password'];                           // SMTP password
        $mail->SMTPAuth = $this->config['smtp_auth'];                               // Enable SMTP authentication
        $mail->SMTPSecure = $this->config['smtp_secure'];                          // Enable TLS encryption, `ssl` also accepted
        $mail->SMTPOptions = $this->config['smtp_options'];
        return $mail;
    }
}
