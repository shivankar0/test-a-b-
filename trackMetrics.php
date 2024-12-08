<?php
// Get the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Check if data is received
if ($data) {
    // Specify the log file name
    $logFile = 'metrics.log';
    
    // Create the log entry with timestamp, version, IP address, and user data
    $logEntry = sprintf(
        "[%s] home: %s, IP: %s, Timestamp: %s\n",
        date('Y-m-d H:i:s'),
        $data['home'], // Either "A" or "B"
        $_SERVER['REMOTE_ADDR'], // User's IP address
        $data['timestamp'] // The timestamp from the client side
    );

    // Append the log entry to the log file
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Respond with a 200 status code (OK)
http_response_code(200);
?>
