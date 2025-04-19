<?php
// session_start();

require_once '../vendor/autoload.php';
use App\APIResponse;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

// $storedOTP = $_SESSION['otp'] ?? null;
$otp = $data['otp'] ?? null;


if ($otp === null) {
    new APIResponse(false, 'OTP not provided');
    exit;
}

// if ($otp == $storedOTP) {
//     unset($_SESSION['otp']); // Optional: clear OTP after match
//     new APIResponse(true, 'matched', $otp);
// } else {
//     new APIResponse(false, 'not matched');
// }

new APIResponse(true, 'matched');

?>
