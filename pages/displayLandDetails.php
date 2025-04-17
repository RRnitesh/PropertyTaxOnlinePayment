<?php
use App\APIResponse;
session_start();
require_once '../vendor/autoload.php';

header('Content-Type: application/json');

// Verify session data exists
if (!isset($_SESSION['pre_verified_data'])) {
    http_response_code(401);
    new APIResponse(false, "Unauthorized access - session data not set", null);
    exit;
}

$data = $_SESSION['pre_verified_data'];


// Prepare response data
$response = [
    'user_info' => $data['user_info'] ?? null,
    'land_entries' => $data['land_entries'] ?? []
];

new APIResponse(true, "Data retrieved successfully", $response);

