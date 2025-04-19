import { formatCurrency } from './utils.js';

export function calculateTax() {
  const button = document.getElementById("calculate");
  const landTotal = parseFloat(button.dataset.grandTotal) || 0;
  const buildingTotal = parseFloat(button.dataset.buildingTotal) || 0;
  const amount = landTotal + buildingTotal;

  document.getElementById("totalcost").innerHTML = `
    <tr>
      <th>land valution</th>
      <th>building valutation</th>
      <th>Total Property Value</th>
    </tr>
    <tr>
      <td>${formatCurrency(landTotal)}</td>
      <td>${formatCurrency(buildingTotal)}</td>
      <td>${formatCurrency(amount)}</td>
    </tr>
  `;

  fetch("tax_slabs.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ amount })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status) {
      const taxDetails = data.responseData.TaxDetails[0];
      const tableBody = document.getElementById("tax-table-body");
      
      tableBody.innerHTML = data.responseData.AllDetails.map(detail => `
        <tr ${detail.id === taxDetails.id ? 'style="background-color: #ffff00"' : ''}>
          <td>${detail.id}</td>
          <td>${detail.min_amount.toLocaleString()}</td>
          <td>${detail.max_amount || ''}</td>
          <td>${detail.fixed_tax.toLocaleString()}</td>
        </tr>
      `).join('');

      const totalAmountDiv = document.getElementById("total-amount");
      totalAmountDiv.setAttribute("data-amount", taxDetails.fixed_tax);
      totalAmountDiv.innerHTML = `<h3>Total Tax Amount: ${taxDetails.fixed_tax.toLocaleString()}</h3>`;
      
      document.getElementById("tax-table").style.display = "table";
      document.getElementById("total-amount").style.display = "block";
      document.getElementById("result").style.display = "block";
    }
  })
  .catch(console.error);
}

// Add event listener
document.getElementById('calculate')?.addEventListener('click', calculateTax);