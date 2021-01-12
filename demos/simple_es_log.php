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

$repeatTime = 5;
$sumTime = 0;
for ($i = 0; $i < $repeatTime; $i++) {
    $start = microtime(true);
    $res = $logger->info('test.info', 'log info demo', [
        'key' => [
            'key1' => 'sec',
            'key2' => $i,
        ]
    ]);
    $end = microtime(true);

    $sumTime += ($end - $start);
}

echo "\nsum:".$sumTime.',avg:'.($sumTime/$repeatTime)."\n";