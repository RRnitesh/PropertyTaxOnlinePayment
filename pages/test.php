<?php
use App\Getinformation;
require_once '../vendor/autoload.php';

// Create instance and get data
$getInfo = new Getinformation("bhaktapur", "bhaktapur", "12bha", 655, "1-0-0-0");
$result = $getInfo->getAllData();

// Check for errors and output
if (isset($result['error'])) {
    echo json_encode(['error' => $result['error']]);
} else {
    echo json_encode(['data' => $result], JSON_PRETTY_PRINT);
}