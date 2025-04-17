document.addEventListener("DOMContentLoaded", () => {
  let grandTotal = 0;
  
  fetch("displayLandDetails.php")
    .then(res => res.json())
    .then(data => {
      console.log("API Response:", data);
      
      // Check the correct response structure
      if (data.status && data.responseData && data.responseData.land_entries.length > 0) {
        const user = data.responseData.user_info;
        const landEntries = data.responseData.land_entries;

        // Display user info
        const userInfoDiv = document.getElementById("user-info");
        userInfoDiv.innerHTML = `
          <ul>
            <li><strong>Name:</strong> ${user.name}</li>
            <li><strong>Citizenship No:</strong> ${user.citizenship_num}</li>
            <li><strong>Email:</strong> ${user.email}</li>
          </ul>
        `;

        // Populate land table
        const landTableBody = document.querySelector("#land-table tbody");
        landTableBody.innerHTML = ''; // Clear existing content
        
        landEntries.forEach(entry => {
          // Calculate total cost: (area_in_feet / 342.25) * rate_per_anna
          const areaInFeet = parseFloat(entry.area_in_feet) || 0;
          const ratePerAnna = parseFloat(entry.landrate.rateper_anna) || 0;
          const totalCost = (areaInFeet / 342.25) * ratePerAnna;
          grandTotal += totalCost;

          
          landTableBody.innerHTML += `
            <tr>
              <td>${entry.mapnumber}</td>
              <td>${entry.kitanumber}</td>
              <td>${entry.area}</td>
              <td>${formatCurrency(entry.landrate.rateper_anna)}</td>
              <td>${entry.landrate.road_type}</td>
              <td>${entry.landrate.road_diameter || ''}</td>
              <td>${areaInFeet.toFixed(2)}</td>
              <td>${formatCurrency(totalCost)}</td>
              <td>${entry.landrate.locationName || ''}</td>
            </tr>
          `;
        });

        // Store grandTotal
        document.getElementById('calculate').dataset.grandTotal = grandTotal;

        // Populate building info
        const buildingTablesDiv = document.getElementById("building-tables");
        buildingTablesDiv.innerHTML = ''; // Clear existing content
        let buildingGrandTotal = 0;

        landEntries.forEach((entry, index) => {
          if (entry.buildingInfo) {
            const building = entry.buildingInfo;
            const buildingCost = parseFloat(building.area) * parseFloat(building.rate);
            buildingGrandTotal += buildingCost;
            
            buildingTablesDiv.innerHTML += `
              <div class="building-section">
                <h3>Building ${index + 1}</h3>
                <table class="building-table">
                  <thead>
                    <tr>
                      <th>Map Number</th>
                      <th>Kita Number</th>
                      <th>Building Type</th>
                      <th>Area</th>
                      <th>Rate per sq ft</th>
                      <th>Total Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>${entry.mapnumber}</td>
                      <td>${entry.kitanumber}</td>
                      <td>${building.type}</td>
                      <td>${building.area} sq. ft</td>
                      <td>${formatCurrency(building.rate)}</td>
                      <td>${formatCurrency(buildingCost)}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            `;
          }
        });

        // Store building total
        document.getElementById('calculate').dataset.buildingTotal = buildingGrandTotal;
        
      } else {
        const errorMessage = data.message || 'No data found';
        document.body.innerHTML += `<div class="error-message">${errorMessage}</div>`;
      }
    })
    .catch(err => {
      console.error("Fetch error:", err);
      document.body.innerHTML += `<div class="error-message">Error loading data: ${err.message}</div>`;
    });
});

function Calculate() {
  const button = document.getElementById('calculate');
  const landTotal = parseFloat(button.dataset.grandTotal) || 0;
  const buildingTotal = parseFloat(button.dataset.buildingTotal) || 0;
  const amount = landTotal + buildingTotal;

  const res = document.getElementById("result");
  const table = document.getElementById("totalcost");
  
  table.innerHTML = `
    <tr>
      <th>Land Valuation</th>
      <th>Building Valuation</th>
      <th>Total Property Value</th>
    </tr>
    <tr>
      <td>${formatCurrency(landTotal)}</td>
      <td>${formatCurrency(buildingTotal)}</td>
      <td>${formatCurrency(amount)}</td>
    </tr>
  `;
  
  table.style.display = "table";
  res.style.display = "block";
  
  fetch("tax_slabs.php", {
    method: "POST",
    headers: {
      "content_type": "application/json"
    },
    body: JSON.stringify({amount: amount})
  })
  .then(res => res.json())
  .then(data =>{
    if(data.status){
      
      const allDetails = data.responseData.AllDetails;
      const taxDetails = data.responseData.TaxDetails[0]; // Get the tax detail to highlight
      const tableBody = document.getElementById('tax-table-body');
      const totalAmountDiv = document.getElementById('total-amount');
      
      // Clear any existing rows
      tableBody.innerHTML = '';
      
      // Populate the table with data
      allDetails.forEach(detail => {
        const row = document.createElement('tr');
        
        // Highlight the row if it matches the TaxDetails ID
        if(detail.id === taxDetails.id) {
          row.style.backgroundColor = '#ffff00'; // Yellow highlight
        }
        
        // Format max amount display (show empty if 0)
        const maxAmount = detail.max_amount === 0 ? '' : detail.max_amount.toLocaleString();
        
        row.innerHTML = `
          <td>${detail.id}</td>
          <td>${detail.min_amount.toLocaleString()}</td>
          <td>${maxAmount}</td>
          <td>${detail.fixed_tax.toLocaleString()}</td>
        `;
        
        tableBody.appendChild(row);
  
      // Display the total tax amount
      totalAmountDiv.innerHTML = `
      <h3>Total Tax Amount: ${taxDetails.fixed_tax.toLocaleString()}</h3>
    `;

    document.getElementById("tax-table").style.display = "table";
    document.getElementById("total-amount").style.display = "block";
    })
    }
    else{
      console.log("data not present");
    }
  })
  .catch(err =>{
    console.log("error from tax_slabs => ",err );
  })
}

function formatCurrency(value) {
  return 'रु ' + Number(value).toLocaleString('ne-NP', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}