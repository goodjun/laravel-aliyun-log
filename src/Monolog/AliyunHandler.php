<?php

namespace Goodjun\AliyunLog\Monolog;

use Aliyun\SLS\Client;
use Aliyun\SLS\Models\LogItem;
use Aliyun\SLS\Requests\PutLogsRequest;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Exception;

class AliyunHandler extends AbstractProcessingHandler
{
    /**
     * @var Logger
     */
    private $storesLogs;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param $level
     * @param $bubble
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->storesLogs = new Logger('AliyunLog');
        $storesLogsHandler = new RotatingFileHandler(storage_path('logs/aliyun-log.log'));
        $this->storesLogs->pushHandler($storesLogsHandler);

        $this->client = new Client(
            config('aliyun-log.endpoint'),
            config('aliyun-log.access_key_id'),
            config('aliyun-log.access_key_secret')
        );

        parent::__construct($level, $bubble);
    }

    /**
     * @param array $record
     * @return void
     */
    protected function write(array $record)
    {
        $logsItem = new LogItem([
            'Level' => $record['level'],
            'LevelName' => $record['level_name'],
            'Message' => $record['message'],
            'Context' => $record['formatted'],
        ]);

        $putLogsRequest = new PutLogsRequest(
            config('aliyun-log.project'),
            config('aliyun-log.log_store'),
            config('aliyun-log.topic'),
            config('aliyun-log.source'),
            $logsItem
        );

        try {
            $this->client->putLogs($putLogsRequest);
        } catch (Exception $exception) {
            $this->storesLogs->log($record['level'], $record['message'], $record['context']);

            $this->storesLogs->error($exception->getMessage());
        }
    }
}
