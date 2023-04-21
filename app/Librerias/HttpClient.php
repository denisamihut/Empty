<?php

namespace App\Librerias;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Log;

class HttpClient
{
    public function getClient()
    {
        return new Client([
            'timeout' => 10,
            'on_stats' => function (TransferStats $stats) {
                $stats = $this->getStats($stats);
                Log::info('HttpClient', $stats);
            },
        ]);
    }

    private function getStats(TransferStats $stats): array
    {
        parse_str($stats->getEffectiveUri()->getQuery(), $queryParams);
        return array_filter([
            'uri' => (string) $stats->getEffectiveUri(),
            'params' => $queryParams,
            'request' => json_decode($stats->getRequest()->getBody(), true),
            'response' => json_decode($stats->getResponse()?->getBody(), true),
            'time' => $stats->getTransferTime(),
            'stats' => $stats->getHandlerStats(),
        ]);
    }
}