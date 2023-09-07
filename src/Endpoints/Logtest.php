<?php
require 'src/Logging/Logger.php'; // Include the logger configuration file


// Log some messages at different log levels
$logger->info('This is an informational message.');
$logger->warning('This is a warning message.');
$logger->error('This is an error message.');
$logger->debug('This is a debug message.');

try {
    // Simulate an exception
    throw new Exception('This is a simulated exception.');
} catch (Exception $e) {
    // Log the exception and its stack trace
    $logger->error('Caught exception: ' . $e->getMessage());
    $logger->error('Exception stack trace: ' . $e->getTraceAsString());
}

echo 'Logging test completed.';
?>
