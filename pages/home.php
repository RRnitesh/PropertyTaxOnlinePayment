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
  <style>
    

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }

    header {
      background-color: #003366;
      display: flex;
      align-items: center;
      padding: 12px 30px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .logo-box {
    width: 60px;
    height: 60px;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 20px;
    border-radius: 8px;
    border: 2px solid #ccc;
    overflow: hidden;
}

.logo-box img {
  width: 100%;
  height: 100%;
  object-fit: contain; /* or "cover" if you want it to fill */
}


    .logo-name {
      color: white;
      font-size: 28px;
      font-weight: 600;
      letter-spacing: 1px;
    }

    .form-container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border: 1px solid #e3e3e3;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #003366;
      font-weight: 600;
    }

    .lang-switcher {
      text-align: right;
      margin-bottom: 15px;
    }

    .lang-switcher button {
      padding: 6px 12px;
      font-size: 14px;
      margin-left: 10px;
      cursor: pointer;
      border: 1px solid #003366;
      background-color: #fff;
      color: #003366;
      border-radius: 4px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }
    .location-row {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
        }

.location-row input {
  flex: 1;
  min-width: 100px;
}


    .submit-btn {
      background-color: #003366;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      display: block;
      margin: 25px auto 0;
    }

    .submit-btn:hover {
      background-color: #002244;
    }
  </style>
  
</head>
<body>

  
  <!-- <h2 style="color: rgb(38,79,139);">enter the land details</h2><br>
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
    <button id="add-item" type="button">Add location</button>
    <input type="submit" value="submit">
  </form> -->


  <header>
    <div class="logo-box"><img src="../assets/images/Emblem_of_Nepal.png" alt=""></div>
    <div class="logo-name">Government of XYZ</div>
  </header>

  <div class="form-container">
    <div class="lang-switcher">
      <label><strong>Language:</strong></label>
      <button onclick="setLanguage('en')">English</button>
      <button onclick="setLanguage('np')">नेपाली</button>
    </div>

    <h2 id="form-title">Land Property Registration</h2>

    <!-- <form id="property-form">
        <div class="form-group">
          <label id="label-district" for="district">District</label>
          <input type="text" id="district" name="district[]" required>
        </div>
      
        <div class="form-group">
          <label id="label-municipality" for="municipality">Municipality</label>
          <select id="municipality" name="municipality[]" required>
            <option value="">-- Select Municipality --</option>
            <option value="Bhaktapur">Municipality 1</option>
            <option value="municipality2">Municipality 2</option>
            <option value="municipality3">Municipality 3</option>
          </select>
        </div>
      
        <div id="location-container">
           One row of inputs will appear here 
        </div>
      
        <button type="button" class="submit-btn" onclick="addLocationRow()">Add Location</button>
        <button type="submit" class="submit-btn" id="submit-button">Submit</button>
      </form> -->

      <form id="land-form">
      <div id="land-entires">
      <div class="landData">
      <div class="form-group">
          <label id="label-district" for="district">District</label>
          <input type="text" id="district" name="district[]" required>
        </div>
      <!-- <input type="text" name="district[]" id="district" value="Bhaktapur"> -->
      <div class="form-group">
          <label id="label-municipality" for="municipality">Municipality</label>
          <select id="municipality" name="municipality[]" required>
            <option value="">-- Select Municipality --</option>
            <option value="Bhaktapur">Bhaktapur</option>
            <option value="Madhyapur Thimi">Madhyapur Thimi</option>
          </select>
        </div>
      
      <!-- <input type="text" name="municipality[]" id="municipality" value="Bhaktapur"> -->
      <div id="location-container">
           <!-- One row of inputs will appear here  -->
        </div>
      <!-- <input type="text" name="mapnumber[]" id="mapnumber" value="17GHA"> -->
      <!-- <input type="number" name="kitanumber[]" id="kitanumber" value="592"> -->
      <!-- <input type="text" name="area[]" id="area" value="0-2-3-1"> -->
      <br>
      </div>
    </div>
    <button type="button" class="submit-btn" onclick="addLocationRow()">Add Location</button>
        <button type="submit" class="submit-btn" id="submit-button">Submit</button>
  </form> 

        </div>


    <script>
      
  
          const labels = {
        en: {
        title: "Land Property Registration",
        district: "District",
        municipality: "Municipality",
        ward: "Ward No.",
        kitta: "Kitta Number",
        area: "Area",
        submit: "Submit"
      },
      np: {
        title: "जग्गा सम्पत्ति दर्ता",
        district: "जिल्ला",
        municipality: "नगरपालिका",
        ward: "वडा नं.",
        kitta: "कित्ता नम्बर",
        area: "क्षेत्रफल",
        submit: "पेश गर्नुहोस्"
      }
    };

    function setLanguage(lang) {
      document.getElementById('form-title').textContent = labels[lang].title;
      document.getElementById('label-district').textContent = labels[lang].district;
      document.getElementById('label-municipality').textContent = labels[lang].municipality;
      document.getElementById('label-ward').textContent = labels[lang].ward;
      document.getElementById('label-kitta').textContent = labels[lang].kitta;
      document.getElementById('label-area').textContent = labels[lang].area;
      document.getElementById('submit-button').textContent = labels[lang].submit;

    }

  function addLocationRow() {
    const container = document.getElementById("location-container");

    const row = document.createElement("div");
    row.className = "location-row";

    row.innerHTML = `
      <input type="text" name="mapnumber[]" placeholder="Ward No."  required />
      <input type="text" name="kitanumber[]" placeholder="Kitta Number" required />
      <input type="text" name="area[]" placeholder="Area"  required />
    `;

    container.appendChild(row);
  }

  // Add first row by default
  window.onload = addLocationRow;
  </script>



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
