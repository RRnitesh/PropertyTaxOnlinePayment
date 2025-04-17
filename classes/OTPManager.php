<?php
namespace App;

class OTPManager
{
    private $mailer;

    // Constructor injects the SendMail instance
    public function __construct(SendMail $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendOTP($email)
    {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'status' => false,
            'message' => 'Invalid email format'
        ];
    }
    
        $otp = rand(000000,999999);
        $_SESSION['otp'] = $otp;
        $email = $_SESSION['pre_verified_data']['user_info']['email'];
        // Use the injected SendMail instance to send the OTP
        return $this->mailer->sendOTP($email, $otp);
    }
}
?>
