<?php

return [
    'access_key_id' => env('ALIYUN_LOG_ACCESS_KEY_ID', ''),

    'access_key_secret' => env('ALIYUN_LOG_ACCESS_KEY_SECRET', ''),

    /**
     * @see https://help.aliyun.com/document_detail/29008.html
     */
    'endpoint' => env('ALIYUN_LOG_ENDPOINT', ''),

    'project' => env('ALIYUN_LOG_PROJECT', ''),

    'log_store' => env('ALIYUN_LOG_LOG_STORE', ''),

    'topic' => env('ALIYUN_LOG_TOPIC', ''),

    'source' => env('ALIYUN_LOG_SOURCE', ''),
];
