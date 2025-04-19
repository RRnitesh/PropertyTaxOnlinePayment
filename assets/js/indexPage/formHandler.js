import { uiState } from './uiManager.js';
import { submitFormData, verifyOTP } from './apiService.js';

export function initializeFormHandler(otpHandler) {
  const form = document.getElementById("land-form");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    uiState.setLoading(true);

    try {
      const formData = new FormData(form);
      const response = await submitFormData(formData);

      if (response.status) {
        otpHandler.show();
      } else {
        uiState.showError(response.responseData);
      }
    } catch (error) {
      uiState.showError(error.message);
    } finally {
      uiState.setLoading(false);
    }
  });
}