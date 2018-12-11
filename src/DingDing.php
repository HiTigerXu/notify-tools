<?php

namespace NotifyTools;

use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: tiger
 * Date: 2018/12/11
 * Time: 下午5:45
 */
class DingDing extends Base
{

    const BASE_URL = 'https://oapi.dingtalk.com/robot/send';

    public function __construct(array $config)
    {
        $_config = [
            'token' => 'xxx',
        ];
        $this->config = array_merge($_config, $config);
    }


    public function send(array $options)
    {
        $client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout' => 60
        ]);

        $message = [
            'msgtype' => isset($options['msgtype']) ? $options['msgtype'] : 'text',
            'text' => [
                'content' => $options['content']
            ],
            'at' => [
                //'atMobiles' => [],
                'isAtAll' => false
            ]
        ];

        if (!empty($options['at_all'])) {
            $message['at']['isAtAll'] = true;
        } elseif (!empty($options['at_mobiles'])) {
            $message['at']['atMobiles'] = $options['at_mobiles'];
        }

        $params = [
            'json' => $message
        ];
        try {
            $response = $client->request('POST', self::BASE_URL . '?access_token=' . $this->config['token'], $params);
        } catch (GuzzleException $e) {
            $this->error_info = '发送失败：' . $e->getMessage();
            return false;
        }
        $data = (string)$response->getBody();
        $result = json_decode($data, true);
        if ($result === false || $result['errmsg'] != 'ok') {
            $this->error_info = '发送失败：接口错误' . $result['errmsg'];
            return false;
        }

        return true;
    }
}