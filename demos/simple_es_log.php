<?php
use cmever\Log\ESLog;
// 1. load autoload.php
require(__DIR__.'/../vendor/autoload.php');

// 2. init config
ESLog::setGlobalConfig([
    'log_url' => 'http://logserver', // !!! please modify your log url
    'server_name' => 'demo',
]);

// 3. use ESLog to log info
$logger = new ESLog();
$res = $logger->info('test.info', 'log info demo', [
    'key' => [
        'key1' => 'sec'
    ]
]);

// 4. please to check es server logs
if ($res) {
    echo "Log successfully";
} else {
    echo "Log error!";
}