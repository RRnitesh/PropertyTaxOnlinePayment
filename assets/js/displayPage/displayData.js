import { formatCurrency } from './utils.js';

export function initializeDataDisplay() {
  document.addEventListener("DOMContentLoaded", () => {
    let grandTotal = 0;

    fetch("displayLandDetails.php")
      .then((res) => res.json())
      .then((data) => {
        if (data.status && data.responseData?.land_entries?.length) {
          const user = data.responseData.user_info;
          const landEntries = data.responseData.land_entries;

          // Display user info
          document.getElementById("user-info").innerHTML = `
            <ul>
              <li><strong>Name:</strong> ${user.name}</li>
              <li><strong>Citizenship No:</strong> ${user.citizenship_num}</li>
              <li><strong>Email:</strong> ${user.email}</li>
            </ul>
          `;

          // Populate land table
          const landTableBody = document.querySelector("#land-table tbody");
          landTableBody.innerHTML = landEntries.map(entry => {
            const areaInFeet = parseFloat(entry.area_in_feet) || 0;
            const ratePerAnna = parseFloat(entry.landrate.rateper_anna) || 0;
            const totalCost = (areaInFeet / 342.25) * ratePerAnna;
            grandTotal += totalCost;

            return `
              <tr>
                <td>${entry.mapnumber}</td>
                <td>${entry.kitanumber}</td>
                <td>${entry.area}</td>
                <td>${formatCurrency(entry.landrate.rateper_anna)}</td>
                <td>${entry.landrate.road_type}</td>
                <td>${entry.landrate.road_diameter || ""}</td>
                <td>${areaInFeet.toFixed(2)}</td>
                <td>${formatCurrency(totalCost)}</td>
                <td>${entry.landrate.locationName || ""}</td>
              </tr>
            `;
          }).join('');

          // Store totals
          const calculateBtn = document.getElementById("calculate");
          calculateBtn.dataset.grandTotal = grandTotal;
          
          // Handle building info
          let buildingGrandTotal = 0;
          document.getElementById("building-tables").innerHTML = landEntries
            .filter(entry => entry.buildingInfo)
            .map((entry, index) => {
              const building = entry.buildingInfo;
              const buildingCost = parseFloat(building.area) * parseFloat(building.rate);
              buildingGrandTotal += buildingCost;

              return `
                <div class="building-section">
                  <h3>Building ${index + 1}</h3>
                  <table class="building-table">
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
            }).join('');

          calculateBtn.dataset.buildingTotal = buildingGrandTotal;
        }
      })
      .catch(console.error);
  });
}