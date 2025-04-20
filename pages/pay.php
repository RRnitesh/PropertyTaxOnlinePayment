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

$successurl = ' https://1e1d-45-64-161-162.ngrok-free.app/E-Governance/pages/successPayment.php';
$failurl = ' https://1e1d-45-64-161-162.ngrok-free.app/E-Governance/pages/failedPayment.php';
echo $response->generateForm($successurl,$failurl);



?>