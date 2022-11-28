<?php

namespace Goodjun\AliyunLog;

use Aliyun\SLS\Client;
use Aliyun\SLS\Models\LogItem;
use Aliyun\SLS\Requests\PutLogsRequest;

class AliyunLogClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var PutLogsRequest
     */
    private $putLogsRequest;

    /**
     * AliyunLogClient constructor.
     * @param $endpoint
     * @param $accessKeyId
     * @param $accessKey
     * @param $project
     * @param $logStore
     * @param null $topic
     * @param null $source
     */
    public function __construct($endpoint, $accessKeyId, $accessKey, $project, $logStore, $topic = null, $source = null)
    {
        $this->client = new Client($endpoint, $accessKeyId, $accessKey);

        $this->putLogsRequest = new PutLogsRequest($project, $logStore, $topic, $source);
    }

    /**
     * @param array $data
     * @throws \Aliyun\SLS\Exception
     */
    public function putLogs($data)
    {
        $logsItem = new LogItem($data);

        $this->putLogsRequest->setLogItems([$logsItem]);

        $this->client->putLogs($this->putLogsRequest);
    }
}