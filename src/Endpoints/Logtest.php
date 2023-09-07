
<?php
require 'src/Logging/LoggingManager.php'; // Include the LoggingManager class

// Create a 'security' logger instance
$securityLoggerManager = new LoggingManager('security', 'Logs/security.log');
$securityLogger = $securityLoggerManager->getLogger();

// Log some messages at different log levels
$securityLogger->info('This is an informational message.');
$securityLogger->warning('This is a warning message.');
$securityLogger->error('This is an error message.');
$securityLogger->debug('This is a debug message.');

try {
    // Simulate an exception
    throw new Exception('This is a simulated exception.');
} catch (Exception $e) {
    // Log the exception and its stack trace
    $securityLogger->error('Caught exception: ' . $e->getMessage());
    $securityLogger->error('Exception stack trace: ' . $e->getTraceAsString());
}

echo 'Logging test completed.';
?>
