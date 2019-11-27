<?php

namespace Arvan\Vod;

class Configuration
{
    /**
     * @var string
     */
    public static $apiKey;

    /**
     * @var string
     */
    private $host = 'https://napi.arvancloud.com/vod/2.0';

    /**
     * Debug switch (default set to false).
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * Debug file location (log to STDOUT by default).
     *
     * @var string
     */
    protected $debugFile = 'php://output';

    /**
     * Debug file location (log to STDOUT by default).
     *
     * @var string
     */
    protected $tempFolderPath;

    /**
     * set apiKey.
     *
     * @return $this
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * get host.
     *
     * @return string host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * get apiKey.
     *
     * @return string apiKey
     */
    public function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Sets debug flag.
     *
     * @param bool $debug Debug flag
     *
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Gets the debug flag.
     *
     * @return bool
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Sets the debug file.
     *
     * @param string $debugFile Debug file
     *
     * @return $this
     */
    public function setDebugFile($debugFile)
    {
        $this->debugFile = $debugFile;

        return $this;
    }

    /**
     * Gets the debug file.
     *
     * @return string
     */
    public function getDebugFile()
    {
        return $this->debugFile;
    }

    /**
     * Sets the temp folder path.
     *
     * @param string $tempFolderPath Temp folder path
     *
     * @return $this
     */
    public function setTempFolderPath($tempFolderPath)
    {
        $this->tempFolderPath = $tempFolderPath;

        return $this;
    }

    /**
     * Gets the temp folder path.
     *
     * @return string Temp folder path
     */
    public function getTempFolderPath()
    {
        return $this->tempFolderPath;
    }

    /**
     * Gets the essential information for debugging.
     *
     * @return string The report for debugging
     */
    public static function toDebugReport()
    {
        $report = 'PHP SDK (Arvan\Vod) Debug Report:'.PHP_EOL;
        $report .= '    OS: '.php_uname().PHP_EOL;
        $report .= '    PHP Version: '.PHP_VERSION.PHP_EOL;
        $report .= '    OpenAPI Spec Version: 2.0'.PHP_EOL;

        return $report;
    }
}
