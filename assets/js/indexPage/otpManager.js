export function initializeOTPHandler(onComplete) {
  const otpModalElement = document.getElementById("otpModal");
  if (!otpModalElement) return null;

  const otpModal = new bootstrap.Modal(otpModalElement);
  const otpInputs = Array.from(document.querySelectorAll(".otp-box"));
  const otpError = document.getElementById("otpError");

  // Event listeners setup
  function setupEventListeners() {
    otpInputs.forEach((input, index) => {
      // Clear previous listeners to avoid duplicates
      input.replaceWith(input.cloneNode(true));
      
      // Get fresh reference after clone
      const freshInput = otpInputs[index] = document.querySelectorAll(".otp-box")[index];

      freshInput.addEventListener("input", (e) => {
        if (e.data && !e.data.match(/^\d+$/)) {
          e.target.value = '';
          return;
        }
        
        if (e.target.value.length === 1 && index < otpInputs.length - 1) {
          setTimeout(() => otpInputs[index + 1].focus(), 10);
        }
        
        checkAutoSubmit();
      });

      freshInput.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && e.target.value === "" && index > 0) {
          setTimeout(() => otpInputs[index - 1].focus(), 10);
        }
      });
    });
  }

  // Set up modal shown event
  otpModalElement.addEventListener('shown.bs.modal', () => {
    setupEventListeners();
    setTimeout(() => {
      otpInputs[0].focus();
      otpInputs[0].select();
    }, 100);
  });

  function checkAutoSubmit() {
    const otp = otpInputs.map(input => input.value).join("");
    if (otp.length === 6) {
      onComplete(otp);
    }
  }

  return {
    show: () => {
      otpInputs.forEach(input => input.value = "");
      otpModal.show();
    },
    hide: () => otpModal.hide(),
    setError: (message) => {
      otpError.textContent = message;
      otpInputs.forEach(input => input.value = "");
      setTimeout(() => otpInputs[0].focus(), 100);
    }
  };
}