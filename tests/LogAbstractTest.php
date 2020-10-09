<?php

use cmever\Log\LogAbstract;
use PHPUnit\Framework\TestCase;

class LogInstance extends LogAbstract
{
    public function log(string $event, string $level, string $message, array $extraData): bool
    {
        return true;
    }
}

class LogAbstractTest extends TestCase
{
    public function test_set_global()
    {
        LogInstance::setGlobalConfig([
            'test' => 1,
        ]);

        $logger = new LogInstance();
        $config = $logger->getConfig();
        $this->assertArrayHasKey('test', $config, 'test set global key');
        $this->assertEquals(1, $config['test'], 'test set global equals');


        $logger2 = new LogInstance();
        $config2 = $logger2->getConfig();
        $this->assertArrayHasKey('test', $config2, 'test set global 2 key');
        $this->assertEquals(1, $config2['test'], 'test set global 2 equals');
    }

    public function test_set_config()
    {
        $logger = new LogInstance();
        $logger->setConfig([
            'test' => 1,
        ]);
        $config = $logger->getConfig();
        $this->assertArrayHasKey('test', $config, 'test set config key');
        $this->assertEquals(1, $config['test'], 'test set config equals');


        $logger2 = new LogInstance();
        $logger2->setConfig([
            'test' => 2,
        ]);
        $config2 = $logger2->getConfig();
        $this->assertArrayHasKey('test', $config2, 'test set config 2 key');
        $this->assertEquals(2, $config2['test'], 'test set config 2 equals');
    }
}