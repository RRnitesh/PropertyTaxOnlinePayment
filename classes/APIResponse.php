<?php
namespace App;

class APIResponse{
  public function __construct($status, $message,$responsedata = null)
  {
    header("Content-type: application/json");
    
    echo json_encode([
      "status"=> $status,
      "message"=> $message,
      "responseData" => $responsedata
    ]);
    exit;
  }
}
?>