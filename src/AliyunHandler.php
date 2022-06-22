<?php

namespace Goodjun\AliyunLog;

use Aliyun\SLS\Client;
use Aliyun\SLS\Models\LogItem;
use Aliyun\SLS\Requests\PutLogsRequest;
use Exception;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class AliyunHandler extends AbstractProcessingHandler
{
    const ALIYUN_LOG_FILENAME = 'aliyun-log';

    const LARAVEL_LOG_FILENAME = 'laravel';

    /**
     * @var Logger
     */
    private $laravelLogger;

    /**
     * @var Logger
     */
    private $aliyunLogger;

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
        $this->laravelLogger = new Logger(self::LARAVEL_LOG_FILENAME);
        $laravelLogHandler = new RotatingFileHandler(storage_path('logs/' . self::LARAVEL_LOG_FILENAME . '.log'));
        $this->laravelLogger->pushHandler($laravelLogHandler);

        $this->aliyunLogger = new Logger(self::ALIYUN_LOG_FILENAME);
        $aliyunLogHandler = new RotatingFileHandler(storage_path('logs/' . self::ALIYUN_LOG_FILENAME . '.log'));
        $this->aliyunLogger->pushHandler($aliyunLogHandler);

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
            $this->laravelLogger->log($record['level'], $record['message'], $record['context']);

            $this->aliyunLogger->error($exception->getMessage());
        }
    }
}
