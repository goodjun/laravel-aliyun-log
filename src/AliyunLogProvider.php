<?php

namespace Goodjun\AliyunLog;

use Illuminate\Support\ServiceProvider;

class AliyunLogProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/aliyun-log.php' => config_path('aliyun-log.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}