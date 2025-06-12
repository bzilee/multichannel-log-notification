<?php

namespace Bzilee\MultichannelLog\Logging;

use Monolog\Formatter\FormatterInterface;

class MultichannelLogFormatter implements FormatterInterface
{
    public function format(array $record)
    {
        $message = "[{$record['datetime']}] {$record['channel']}.{$record['level_name']}: {$record['message']}";
        if (!empty($record['context'])) {
            $message .= ' ' . json_encode($record['context'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return $message;
    }

    public function formatBatch(array $records)
    {
        $message = '';
        foreach ($records as $record) {
            $message .= $this->format($record) . "\n";
        }
        return $message;
    }
}