<?php


use App\APIResponse;
use App\Getinformation;
use App\OTPManager;
use App\SendMail;


session_start();
require __DIR__ . "/../vendor/autoload.php";

try {
    // Validate input structure
    if (!isset($_POST["district"]) || !is_array($_POST["district"])) {
        throw new Exception("Invalid form submission format");
    }

    $count = count($_POST["district"]);
    $landEntries = [];
    $userInfo = null;
    $initialCitizenID = null;

    // Process each land entry
    for ($i = 0; $i < $count; $i++) {
        // Validate required fields for each entry
        $requiredFields = ['district', 'municipality', 'mapnumber', 'kitanumber', 'area'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field][$i]) ){
                throw new Exception("Missing field $field in entry $i");
            }
        }

        // Process individual entry
        $getInformation = new Getinformation(
            $_POST["district"][$i],
            $_POST["municipality"][$i],
            $_POST["mapnumber"][$i],
            $_POST["kitanumber"][$i],
            $_POST["area"][$i]
        );

        $entryData = $getInformation->getAllData();

        // Handle entry errors
        if (isset($entryData["error"])) {
            new APIResponse(false,   $entryData["error"]);
            exit;
        }

        // Verify citizen ID consistency
        if ($i === 0) {
            $initialCitizenID = $entryData['checkCitizenId'];
            $userInfo = $entryData['UserInfo'];
        } elseif ($entryData['checkCitizenId'] !== $initialCitizenID) {
            new APIResponse(false, "Citizen ID mismatch in entry $i");
            exit;
        }

                // Prepare building info structure
                $buildingInfo = null;
                if (!empty($entryData['buildingInfo'])) {
                    $buildingInfo = [
                        'type' => $entryData['buildingInfo']['type'],
                        'area' => $entryData['buildingInfo']['area'],
                        'rate' => $entryData['buildingInfo']['rate']
                    ];
                }
        // Store entry data
        $landEntries[] = [
            'district' => $_POST["district"][$i],
            'municipality' => $_POST["municipality"][$i],
            'mapnumber' => $_POST["mapnumber"][$i],
            'kitanumber' => $_POST["kitanumber"][$i],
            'area' => $_POST["area"][$i],
            'landrate' => $entryData['landrate'],
            'area_in_feet' => $entryData['area_in_feet'],
            'buildingInfo' => $entryData['buildingInfo']
        ];
    }

    // Store all data in session
    $_SESSION['pre_verified_data'] = [
        'user_info' => $userInfo,
        'land_entries' => $landEntries,
        'citizen_id' => $initialCitizenID
    ];

    //Send OTP
    $mailer = new SendMail();
    $otpManager = new OTPManager($mailer);
    $response = $otpManager->sendOTP($userInfo['email']);

    if ($response['status'] === true) {
        new APIResponse(true, $response['message']);
    } else {
        new APIResponse(false, $response['message'], $response['errorDetails']);
    }

} catch (Exception $e) {
    new APIResponse(false, "System error: " . $e->getMessage());
}