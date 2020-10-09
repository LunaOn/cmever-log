<?php


namespace cmever\Log;


final class ESLog extends LogAbstract
{
    /**
     * ESLog Global config
     * @var array
     * [
     *  "log_url" => "http://logserver/",
     *  "server_name" => "insweb|ai|color|thirdparty",
     *  "env" => "dev|prod"
     *  "client_ip" => "xxx.xxx.xxx(option)",
     *  "server_ip" => "xxx.xxx.xxx(option)",
     * ]
     */
    protected static $globalConfig = [
        'log_url' => '',
        'server_name' => 'none',
        'env' => null,
        'client_ip' => null,
        'server_ip' => null,
        'timeout' => 3,
    ];

    public function log(string $event, string $level, string $message, array $extraData): bool
    {
        $config = $this->getConfig();
        $data = $this->buildLogJson($event, $level, $message, $extraData);
        $result = self::postJson($config['log_url'] ?? '', $data, $config['timeout']);
        return $result === 'ok';
    }

    /**
     * Build json data for log()
     * @param string $event
     * @param string $level
     * @param string $message
     * @param array $extraData
     * @return array
     */
    protected function buildLogJson(string $event, string $level, string $message, array $extraData): array
    {
        $config = $this->getConfig();
        if (is_null($config['env']) && defined('APP_ENV')) {
            $config['env'] = APP_ENV;
        }
        if (is_null($config['client_ip'])) {
            $config['client_ip'] = $_SERVER['REMOTE_ADDR'] ?? '';
        }
        if (is_null($config['server_ip'])) {
            $config['server_ip'] = $_SERVER['SERVER_ADDR'] ?? '';
        }
        return [
            'server_name' => $config['server_name'] ?? 'none',
            'env' => $config['env'] ?? 'none',
            'level' => $level,
            'event' => $event,
            'message' => $message,
            'extra_data' => $extraData,
            'server_time' => gmdate('Y-m-d\TH:i:s\Z'), // always UTC time
            'client_ip' => $config['client_ip'] ?? '',
            'server_ip' => $config['server_ip'] ?? '',
        ];
    }

    /**
     * Post JSON to log server
     * @param string $url
     * @param array $content
     * @param int $timeout
     * @return string
     */
    protected static function postJson(string $url, array $content, int $timeout = 3): string
    {
        if (empty($url)) {
            return '';
        }
        $timeout = max($timeout, 0.1); // At least 0.1s
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type:application/json',
                'content' => json_encode($content),
                'timeout' => $timeout,
            ]
        ];
        $context = stream_context_create($options);
        return @file_get_contents($url, false, $context); // disable warning output
    }
}