<?php

namespace Bzilee\MultichannelLog\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Bzilee\MultichannelLog\LogManager;

class MultichannelLogHandler extends AbstractProcessingHandler
{
    protected $logManager;

    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level, true);
        $this->logManager = app('multichannel.log');
    }

    protected function write(array $record): void
    {
        $message = $record['formatted'] ?? $record['message'];
        $level = strtolower($record['level_name']);
        
        // Récupérer les canaux en fonction du niveau de log
        $channels = config("multichannel_log.channels_by_level.$level", 
            explode(',', config('multichannel_log.default_channels', 'email'))
        );

        $this->logManager->send($message, $channels);
    }
}