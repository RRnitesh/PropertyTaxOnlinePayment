<?php
namespace App;

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__. '/../vendor/autoload.php';
class SendMail{
  private $mail;
  private $dotenv;
  public function __construct()
  {
    $this->mail = new PHPMailer(true);
    $this->mail->isSMTP();
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->SMTPAuth = true;
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port = 587;

    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    //1-dirname means look one step outside the folder. if 2-dirname then two steps out.
    $dotenv->load();
  }

  public function sendOTP($email, $otp){
    try{

    // Set credentials from .env
    $this->mail->Username = $_ENV['GMAIL_USERNAME'];
    $this->mail->Password = $_ENV['GMAIL_PASSWORD'];

    //sender and recipient details;
    $this->mail->setFrom($_ENV['GMAIL_USERNAME']);
    $this->mail->addAddress($email);

    //email content
    $this->mail->isHTML(true);
    $this->mail->Subject = 'OTP for Login';
    $this->mail->Body = 'Your OTP is ' . $otp;
    $this->mail->AltBody = 'Your OTP is ' . $otp;

    $this->mail->send();
    
     return  ( 
      [
        'status' => true,
        'message' => 'OTP send successfully',
      ]);
    
  }
  catch(Exception $ex){
    $errorMessage = "failed to send OTP";

    if(strpos($this->mail->ErrorInfo, '550') !== false){
      $errorMessage = 'Error:550::The email address you\'re trying to send to doesn\'t exist or is misspelled.';
    }elseif(strpos($this->mail->ErrorInfo, '553') !== false){
      $errorMessage = 'Error:553::Domain is not registered or allowed by the SMTP server';
    }
    return ( [
      'status' => false,
      'message' => $errorMessage,
      'errorDetails' => $this->mail->ErrorInfo
    ]);
  }
}}


?>