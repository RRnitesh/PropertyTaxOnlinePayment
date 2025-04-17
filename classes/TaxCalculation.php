<?php
namespace App;

use App\DataBaseQuery;
require_once '../vendor/autoload.php';

class TaxCalculation{
  private $amount;
  private $db;

  public function __construct($Amount){
    $this->amount = $Amount;

    $this->db = new DataBaseQuery();
  }

  public function DisplayTax_slabs(){
    $data = $this->getAllTaxAmount();

    $tax = $this->GetSpecificAmount($this->amount);

    return [
      'AllDetails' => $data,
      'TaxDetails' => $tax,
    ];
  }
  private function getAllTaxAmount(){
    $query = "SELECT * FROM tax_slabs";
    $result = $this->db->fetchData($query);
    return $result ?? null;
  }

  private function GetSpecificAmount($amount) {
    if ($amount <= 1000000) {  // 0 - 10,00,000
        $min = 0;
        $max = 1000000;
    } elseif ($amount <= 3000000) {  // 10,00,001 - 30,00,000
        $min = 1000001;
        $max = 3000000;
    } elseif ($amount <= 5000000) {  // 30,00,001 - 50,00,000
        $min = 3000001;
        $max = 5000000;
    } elseif ($amount <= 10000000) {  // 50,00,001 - 1,00,00,000
        $min = 5000001;
        $max = 10000000;
    } else {  // 1,00,00,001 and above
        $min = 10000001;
        $max = 0;  // 
    }

    $query = "SELECT id,fixed_tax FROM tax_slabs WHERE min_amount = ? AND max_amount = ?";
    $param = [$min, $max];
    $types = "ii";

    $result = $this->db->fetchData($query, $param, $types);
    return $result ?? null;
}
}

?>