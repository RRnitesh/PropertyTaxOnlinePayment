<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Land Online payment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../assets/js/indexPage/main.js" type="module"></script>
  <link rel="stylesheet" href="../assets/css/home.css">
  <link rel="stylesheet" href="../assets/css/test.css">
</head>
<body>
  <header>

  </header>

  
  <h2 style="color: rgb(38,79,139);">enter the land details</h2><br>
  <h2 style="color: rgb(13,100,253);">enter the land details</h2><br>

  <form id="land-form">
      <div id="land-entires">
      <div class="landData">
      <input type="text" name="district[]" id="district" value="Bhaktapur">
      <input type="text" name="municipality[]" id="municipality" value="Bhaktapur">
      <input type="text" name="mapnumber[]" id="mapnumber" value="17GHA">
      <input type="number" name="kitanumber[]" id="kitanumber" value="592">
      <input type="text" name="area[]" id="area" value="0-2-3-1">
      <br>
      </div>
    </div>
    <div class="landData">
      <input type="text" name="district[]" id="district" value="Bhaktapur">
      <input type="text" name="municipality[]" id="municipality" value="Bhaktapur">
      <input type="text" name="mapnumber[]" id="mapnumber" value="17gha">
      <input type="number" name="kitanumber[]" id="kitanumber" value="593">
      <input type="text" name="area[]" id="area" value="0-0-1-1">
      <br>
    </div>
    <button id="add-item" type="button">Add location</button>
    <input type="submit" value="submit">
  </form>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none;">
    <!-- full screen dimer -->
    <div class="spinner-border text-light" role="status">
      <!-- bootstrap spinner loading... wont be displayed-->
      <span class="visually-hidden">Loading...</span>
    </div>
    <!-- this is acutally shown -->
    <div style="margin-top: 10px;">Processing...</div>
  </div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger rounded-4 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="errorModalLabel">Error</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="errorMessage" class="mb-0 fs-5 text-danger"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="otpModalLabel">Enter OTP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">We've sent an OTP to your email. Please enter it below:</p>
        <div class="d-flex justify-content-center gap-2 mb-3">
          <input type="text" class="otp-box form-control text-center" maxlength="1">
          <input type="text" class="otp-box form-control text-center" maxlength="1">
          <input type="text" class="otp-box form-control text-center" maxlength="1">
          <input type="text" class="otp-box form-control text-center" maxlength="1">
          <input type="text" class="otp-box form-control text-center" maxlength="1">
          <input type="text" class="otp-box form-control text-center" maxlength="1">
        </div>
        <div id="otpError" class="text-danger"></div>
      </div>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
