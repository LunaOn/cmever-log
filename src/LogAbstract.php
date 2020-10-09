<?php


namespace cmever\Log;


abstract class LogAbstract
{
    const LEVEL_DEBUG = 'debug';
    const LEVEL_INFO = 'info';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';
    const LEVEL_FATAL = 'fatal';

    /**
     * Should rewrite by child class
     * @var array
     */
    protected static $globalConfig = [];

    /**
     * customize config by instance
     * @var array
     */
    protected $config = [];

    /**
     * log setting
     * @param array $config
     * @return bool
     */
    public static function setGlobalConfig(array $config): bool
    {
        static::$globalConfig = array_merge(static::$globalConfig, $config);
        return true;
    }

    /**
     * set object config
     * @param array $config
     * @return bool
     */
    public function setConfig(array $config): bool
    {
        $this->config = $config;
        return true;
    }

    /**
     * get config merged globalconfig
     * @return array
     */
    public function getConfig(): array
    {
        return array_merge(static::$globalConfig, $this->config);
    }

    /**
     * Log for level debug
     * @param string $event
     * @param string $message
     * @param array $extraData
     * @return bool
     */
    public function debug(string $event = "", string $message = "", array $extraData = []): bool
    {
        return $this->log(self::LEVEL_DEBUG, $event, $message, $extraData);
    }

    /**
     * Log for level info
     * @param string $event
     * @param string $message
     * @param array $extraData
     * @return bool
     */
    public function info(string $event = "", string $message = "", array $extraData = []): bool
    {
        return $this->log(self::LEVEL_INFO, $event, $message, $extraData);
    }

    /**
     * Log for level warning
     * @param string $event
     * @param string $message
     * @param array $extraData
     * @return bool
     */
    public function warning(string $event = "", string $message = "", array $extraData = []): bool
    {
        return $this->log(self::LEVEL_WARNING, $event, $message, $extraData);
    }

    /**
     * Log for level error
     * @param string $event
     * @param string $message
     * @param array $extraData
     * @return bool
     */
    public function error(string $event = "", string $message = "", array $extraData = []): bool
    {
        return $this->log(self::LEVEL_ERROR, $event, $message, $extraData);
    }

    /**
     * Log for level fatal
     * @param string $event
     * @param string $message
     * @param array $extraData
     * @return bool
     */
    public function fatal(string $event = "", string $message = "", array $extraData = []): bool
    {
        return $this->log(self::LEVEL_FATAL, $event, $message, $extraData);
    }

    /**
     * Recording log
     * @param string $event
     * @param string $level
     * @param string $message
     * @param array $extraData
     * @return bool
     */
    abstract public function log(string $event, string $level, string $message, array $extraData): bool;
}