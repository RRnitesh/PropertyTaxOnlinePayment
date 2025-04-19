export async function submitFormData(formData) {
  try {
    const response = await fetch("check-UserData.php", {
      method: "POST",
      body: formData
    });
    return await response.json();
  } catch (error) {
    throw new Error("Network error: " + error.message);
  }
}

export async function verifyOTP(otp) {
  try {
    const response = await fetch("checkOTP.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ otp })
    });
    return await response.json();
  } catch (error) {
    throw new Error("OTP verification failed: " + error.message);
  }
}