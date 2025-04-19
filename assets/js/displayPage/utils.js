export function formatCurrency(value) {
  return "रु " + Number(value).toLocaleString("ne-NP", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}