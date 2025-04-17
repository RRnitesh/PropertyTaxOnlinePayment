document.addEventListener("DOMContentLoaded", function () {
  // Add new form
  const addButton = document.getElementById("add-item");
  addButton.addEventListener("click", function (e) {
    e.preventDefault();
    const container = document.getElementById("land-entires");
    const originalForm = document.querySelector(".landData");

    const clone = originalForm.cloneNode(true);

    // Clear input of original form clone
    const inputs = clone.querySelectorAll("input");
    inputs.forEach((input) => (input.value = ""));

    // Adding remove button on every cloned form
    const removeBtn = document.createElement("button");
    removeBtn.textContent = "Remove";

    removeBtn.addEventListener("click", function () {
      clone.remove();
    });
    clone.appendChild(removeBtn);
    container.appendChild(clone);
  });

  // Form submission handling
  document.getElementById("land-form").addEventListener("submit", function (e) {
    e.preventDefault();
    document.getElementById("loadingOverlay").style.display = 'flex';
    
    const formData = new FormData(e.target);

    fetch("check-UserData.php", {
      method: "POST",
      body: formData,
    })
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("loadingOverlay").style.display = "none";
      
      if (data.status) {
        console.log("Response Data:", data.responseData);
        console.log("Message:", data.message);

        // Initialize and show OTP modal
        const otpModal = new bootstrap.Modal(document.getElementById("otpModal"));
        otpModal.show();
        
        // Focus on first OTP input when modal is shown
        document.getElementById("otpModal").addEventListener('shown.bs.modal', function () {
          document.querySelector(".otp-box").focus();
        });

        // OTP handling
        const otpInputs = document.querySelectorAll(".otp-box");
        
        otpInputs.forEach((input, index) => {
          // Handle input
          input.addEventListener("input", function() {
            if(this.value.length === 1 && index < otpInputs.length - 1) {
              otpInputs[index + 1].focus();
            }
            checkAutoSubmit();
          });
          
          // Handle backspace
          input.addEventListener("keydown", (e) => {
            if(e.key === "Backspace" && this.value === "" && index > 0) {
              otpInputs[index - 1].focus();
            }
          });
        });

        function checkAutoSubmit() {
          const otp = Array.from(otpInputs).map(input => input.value).join("");
          if(otp.length === 6) {
            submitOTP(otp);
          }
        }

        function submitOTP(otp) {
          document.getElementById("otpError").textContent = "";
          document.getElementById("loadingOverlay").style.display = 'flex';

          fetch("checkOTP.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ otp }),
          })
          .then((response) => response.json())
          .then((data) => {
            document.getElementById("loadingOverlay").style.display = "none";
            
            if (data.status) {
              otpModal.hide();
              window.location.href = 'display.html';
            } else {
              
              document.getElementById("otpError").textContent = data.message;
              // Clear OTP inputs on error
              otpInputs.forEach(input => input.value = "");
              otpInputs[0].focus();
            }
          })
          .catch((err) => {
            document.getElementById("loadingOverlay").style.display = "none";
            console.error("Error from checkOTP file", err);
          });
        }
      } else {
        // Show error modal
        console.log(data.responseData);
        document.getElementById("errorMessage").textContent = data.responseData;
        new bootstrap.Modal(document.getElementById("errorModal")).show();
      }
    })
    .catch((err) => {
      document.getElementById("loadingOverlay").style.display = "none";
      console.error("Error from handle-form.php", err);
    });
  });
});
