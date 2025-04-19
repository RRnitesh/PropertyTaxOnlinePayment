export function initializeDynamicForms() {
  const addButton = document.getElementById("add-item");
  if (!addButton) return;

  addButton.addEventListener("click", (e) => {
    e.preventDefault();
    const container = document.getElementById("land-entires");
    const originalForm = document.querySelector(".landData");
    
    if (!container || !originalForm) return;

    const clone = originalForm.cloneNode(true);
    const inputs = clone.querySelectorAll("input");
    inputs.forEach((input) => (input.value = ""));

    const removeBtn = document.createElement("button");
    removeBtn.textContent = "Remove";
    removeBtn.addEventListener("click", () => clone.remove());
    
    clone.appendChild(removeBtn);
    container.appendChild(clone);
  });
}