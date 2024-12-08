<?php
// Set headers to allow cross-origin requests (if needed)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $inputData = file_get_contents('php://input');

    // Log the raw input data for debugging
    error_log("Raw input data: " . $inputData);

    // Check if the input data is empty
    if (empty($inputData)) {
        echo json_encode(['status' => 'error', 'message' => 'Empty input data.']);
        exit();
    }

    // Decode the JSON input
    $decodedData = json_decode($inputData, true);

    // Check if decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input.']);
        exit();
    }

    // Check if required fields are present
    if (isset($decodedData['home']) && isset($decodedData['timestamp'])) {
        $home = $decodedData['home'];
        $timestamp = $decodedData['timestamp'];
        $ipAddress = $_SERVER['REMOTE_ADDR']; // Get the client IP address

        // Format the log entry
        $logEntry = "[" . date('Y-m-d H:i:s') . "] home: $home, IP: $ipAddress, Timestamp: $timestamp\n";

        // Path to the log file
        $logFile = 'metrics.log';

        // Append the log entry to the file
        if (file_put_contents($logFile, $logEntry, FILE_APPEND)) {
            // Respond with success
            echo json_encode(['status' => 'success', 'message' => 'Data logged successfully.']);
        } else {
            // Respond with an error if writing to the file fails
            echo json_encode(['status' => 'error', 'message' => 'Failed to write to log file.']);
        }
    } else {
        // Respond with an error if required data is missing
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
    }
} else {
    // Respond with an error if the request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
