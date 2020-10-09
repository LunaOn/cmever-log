<?php

use cmever\Log\ESLog;
use PHPUnit\Framework\TestCase;


/**
 * Class EsLogTest
 * Please check Kibana after executed
 */
class EsLogTest extends TestCase
{
    /**
     * empty config
     */
    public function test_empty_log_url()
    {
        $logger = new ESLog();
        $this->assertFalse($logger->info(
            'phpunit.test_server_log',
            'test content',
            [
                'key1' => [
                    'key1.1' => 'value1.1',
                ],
                'key2' => 'Hello World!'
            ]
        ), 'Test empty log_url error!');
    }

    /**
     * instance config with outer server
     */
    public function test_outer_server_log()
    {
        $logger = new ESLog();
        $logger->setConfig([
            'log_url' => __DIR__.'/es-log-server-response.txt',
        ]);
        $this->assertTrue($logger->info(
            'phpunit.test_server_log',
            'test content',
            [
                'key1' => [
                    'key1.1' => 'value1.1',
                ],
                'key2' => 'Hello World!'
            ]
        ), 'Test outer server error!');
    }

    /**
     * set global config
     */
    public function test_global_config()
    {
        ESLog::setGlobalConfig([
            'log_url' => __DIR__.'/es-log-server-response.txt',
        ]);
        $logger = new ESLog();
        $this->assertTrue($logger->info(
            'phpunit.test_server_log',
            'test content',
            [
                'key1' => [
                    'key1.1' => 'value1.1',
                ],
                'key2' => 'Hello World!'
            ]
        ), 'Test global config 1 error!');

        $logger2 = new ESLog();
        $this->assertTrue($logger2->info(
            'phpunit.test_server_log',
            'test content',
            [
                'key1' => [
                    'key1.1' => 'value1.1',
                ],
                'key2' => 'Hello World!'
            ]
        ), 'Test global config 2 error!');
    }
}