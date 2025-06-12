<?php

namespace Bzilee\MultichannelLog;

use Illuminate\Support\ServiceProvider;
use Bzilee\MultichannelLog\Logging\MultichannelLogHandler;
use Bzilee\MultichannelLog\Logging\MultichannelLogFormatter;

class MultichannelLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/multichannel_log.php' => config_path('multichannel_log.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/multichannel_log.php', 'multichannel_log');

        $this->app->singleton('multichannel.log', function ($app) {
            return new LogManager($app);
        });

        $this->app->extend('log', function ($log, $app) {
            $log->extend('multichannel', function ($app, $config) {
                $handler = new MultichannelLogHandler(
                    $app['config']->get('logging.channels.multichannel.level', 'debug')
                );
                $handler->setFormatter(new MultichannelLogFormatter());
                return $handler;
            });
            return $log;
        });
    }
}