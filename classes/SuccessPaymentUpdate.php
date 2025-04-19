<?php
namespace App;
require_once '../vendor/autoload.php';
class SuccessPaymentUpdate{
  private $amount;
  private $transID;

  private $db;

  public function __construct($totalAmount, $transactionUUID) {
    $this->amount = $totalAmount ;
    $this->transID = $transactionUUID;

    $this->db = new DataBaseQuery();
  }
  //paymentoperation
    // id INT AUTO_INCREMENT PRIMARY KEY,
    // amount DECIMAL(10, 2) NOT NULL,
    // transactionDate DATETIME NOT NULL,
    // transactionID VARCHAR(100) NOT NULL UNIQUE

    public function successpayment(){
      if($this->UpdateTable())
      {
        echo json_encode(
          [
            "status" => true,
          ]
          );
      }else{
        echo json_encode(
          [
            "status" => false,
          ]
          );
      }

    }
    private function UpdateTable(){
      $sql = "INSERT INTO paymentoperation(amount, transactionDate, transactionID) 
              VALUES (?, NOW(), ?)";
  
      $param = [$this->amount, $this->transID];
      $types = "ds";  // amount = decimal, transID = string
  
      try {
          $result = $this->db->insertData($sql, $param, $types);
          return $result;
      } catch (\Exception $e) {
          // Log or handle error if needed
          return false;
      }
  }
  
}

$da = new SuccessPaymentUpdate(500,'124asd4');
$da->successpayment();

?>