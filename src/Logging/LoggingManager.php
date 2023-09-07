<?php

require 'vendor/autoload.php'; // Include Composer's autoloader

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggingManager
{
    private $logger;

    public function __construct($logName, $logFile)
    {
        // Create a logger instance
        $this->logger = new Logger($logName);

        // Create a log file handler (you can change the log file path)
        $handler = new StreamHandler($logFile, Logger::DEBUG);

        // Add the handler to the logger
        $this->logger->pushHandler($handler);
    }

    public function getLogger()
    {
        return $this->logger;
    }
}
