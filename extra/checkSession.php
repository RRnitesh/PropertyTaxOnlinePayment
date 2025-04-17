<?php
session_start();  // Start the session

// Display all session variables
echo '<pre>';  // Optional: Makes the output more readable
// print_r($_SESSION);
echo '</pre>';
$storedOTP = $_SESSION['otp'] ?? null;
echo $storedOTP;
  ?>  
