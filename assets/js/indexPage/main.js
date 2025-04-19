import { initializeDynamicForms } from './dynamicForm.js';
import { initializeOTPHandler } from './otpManager.js';
import { initializeFormHandler } from './formHandler.js';
import { uiState } from './uiManager.js';
import { verifyOTP } from './apiService.js';

document.addEventListener("DOMContentLoaded", () => {
  console.log("Initializing modules...");
  
  // Initialize all modules
  initializeDynamicForms();

  // Set up OTP handler with proper async/await
  const otpHandler = initializeOTPHandler(async (otp) => {
    console.log("OTP entered:", otp);
    uiState.setLoading(true);
    try {
      const result = await verifyOTP(otp);
      console.log("OTP verification result:", result);
      
      if (result.status) {
        otpHandler.hide();
        window.location.href = 'display.html';
      } else {
        otpHandler.setError(result.message || "Invalid OTP");
      }
    } catch (error) {
      console.error("OTP verification error:", error);
      otpHandler.setError("An error occurred. Please try again.");
    } finally {
      uiState.setLoading(false);
    }
  });

  // Initialize form handling
  initializeFormHandler(otpHandler);
});