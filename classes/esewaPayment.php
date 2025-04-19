<?php
namespace App;

use Dotenv\Dotenv;
require_once '../vendor/autoload.php';

class EsewaPayment{
  private $totalAmount;
  private $transactionUUID;
  private $productCode;
  private $secret;
  private $signedFieldNames;


  public function __construct($total_amount) {
    //loading .env file
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    $this->totalAmount = $total_amount;
    $this->transactionUUID = uniqid();
    $this->productCode = "EPAYTEST";//Test product code as per eSewa documentation
    $this->secret = $_ENV['SECRET'];
    $this->signedFieldNames = "total_amount,transaction_uuid,product_code";
  }

  private function generateSignature(){
    $message = "total_amount={$this->totalAmount},transaction_uuid={$this->transactionUUID},product_code={$this->productCode}";
    $hashed = hash_hmac('sha256', $message, $this->secret, true);
    return base64_encode($hashed);
  }

  public function generateForm($successBaseUrl, $failureBaseUrl)
  {
      $signature = $this->generateSignature();

        $successUrl = $successBaseUrl;
        $failureUrl = $failureBaseUrl;
      return "
      <form id='esewaForm' action='https://rc-epay.esewa.com.np/api/epay/main/v2/form' method='POST'>
          <input type='hidden' name='amount' value='{$this->totalAmount}'>
          <input type='hidden' name='tax_amount' value='0'>
          <input type='hidden' name='total_amount' value='{$this->totalAmount}'>
          <input type='hidden' name='transaction_uuid' value='{$this->transactionUUID}'>
          <input type='hidden' name='product_code' value='{$this->productCode}'>
          <input type='hidden' name='product_service_charge' value='0'>
          <input type='hidden' name='product_delivery_charge' value='0'>
          <input type='hidden' name='success_url' value='{$successUrl}'>
          <input type='hidden' name='failure_url' value='{$failureUrl}'>
          <input type='hidden' name='signed_field_names' value='{$this->signedFieldNames}'>
          <input type='hidden' name='signature' value='{$signature}'>
      </form>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          document.getElementById('esewaForm').submit();
        });
      </script>
      ";
  }
}

?>