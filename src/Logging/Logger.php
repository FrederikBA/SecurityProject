<?php
// logger.php

require 'vendor/autoload.php'; // Include Composer's autoloader

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger instance
$logger = new Logger('my_logger');

// Create a log file handler (you can change the log file path)
$logFile = 'Logs/logfile.log';
$handler = new StreamHandler($logFile, Logger::DEBUG);

// Add the handler to the logger
$logger->pushHandler($handler);






/*
// my_script.php

require 'logger.php'; // Include the logger configuration file

// Now you can use $logger to log messages
$logger->info('This is an informational message.');
$logger->error('This is an error message.');
*/