<?php
session_start();


use App\EsewaPayment;
require_once '../vendor/autoload.php';

//amount 
$amount = (float)$_POST['amount'];

//get user id
$citizenId = $_SESSION['id'];

//call class
$response = new EsewaPayment($amount);

$successurl = 'https://f0ae-43-231-208-235.ngrok-free.app/E-Governance/pages/successPayment.php';
$failurl = 'https://f0ae-43-231-208-235.ngrok-free.app/E-Governance/pages/failedPayment.php';
echo $response->generateForm($successurl,$failurl);



?>