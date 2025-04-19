export const uiState = {
  setLoading: (isLoading) => {
    const overlay = document.getElementById("loadingOverlay");
    if (overlay) overlay.style.display = isLoading ? "flex" : "none";
  },

  showError: (message) => {
    const errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
    document.getElementById("errorMessage").textContent = message;
    errorModal.show();
  }
};