import { initializeDataDisplay } from './displayData.js';
import { calculateTax } from './taxCalculator.js';

initializeDataDisplay();

// Optional: Still expose to window if needed elsewhere
window.Calculate = calculateTax;