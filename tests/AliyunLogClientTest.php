<?php

namespace Tests;

use Goodjun\AliyunLog\AliyunLogClient;
use Orchestra\Testbench\TestCase;

class AliyunHandlerTest extends TestCase
{
    public function testPutLogs()
    {
        $aliyunLogClient = new AliyunLogClient(
            env('ALIYUN_LOG_ENDPOINT'),
            env('ALIYUN_LOG_ACCESS_KEY_ID'),
            env('ALIYUN_LOG_ACCESS_KEY_SECRET'),
            env('ALIYUN_LOG_PROJECT'),
            env('ALIYUN_LOG_LOG_STORE')
        );

        $data = [
            'Level' => 200,
            'LevelName' => 'INFO',
            'Message' => 'AliyunLogClientTest',
            'Context' => json_encode(['date' => now()->toDateString()]),
        ];

        $aliyunLogClient->putLogs($data);

        $this->assertTrue(true);
    }
}