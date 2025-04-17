<?php

use App\APIResponse;
use App\TaxCalculation;
//"When I write new YourClass(), I mean the class inside the App namespace."
require_once '../vendor/autoload.php';
//"Hey — use Composer's autoloader to handle class loading for me."
//If you don’t load the autoloader, PHP won't know where your classes are, even if you use them.

//get data from frontEnd
$data =json_decode(file_get_contents("php://input"), true);
$amount = $data['amount'] ?? null;

$Info = new TaxCalculation($amount);

$responseData = $Info->DisplayTax_slabs();

new APIResponse(true, "data passed true", $responseData);
?>