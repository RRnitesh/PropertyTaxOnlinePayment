<?php

use App\APIResponse;
// successPayment.php
require_once '../vendor/autoload.php';

$data = $_GET['data'] ?? null;

if ($data) {
    $decoded = urldecode($data);                // Step 1: URL decode
    $json = base64_decode($decoded);            // Step 2: Base64 decode
    $array = json_decode($json, true);          // Step 3: Convert JSON to PHP array

    if (!is_array($array)) {
      new APIResponse(false, 'payment not recieved');
    }
    $totalAmount = $array['total_amount'] ?? null;
    $transactionUUID = $array['transaction_uuid'] ?? null;

    // echo "Total Amount: " . $totalAmount . "<br>";
    // echo "Transaction UUID: " . $transactionUUID;
    
} else {
    echo "No data received.";
}
?>
