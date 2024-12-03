const XLSX = require("xlsx");

// Read the Excel file
const workbook = XLSX.readFile("request.xlsx");

// Access the worksheet named "ORDERS"
const worksheet = workbook.Sheets["ORDERS"];

// Retrieve data from local storage (replace with your actual data)
const purchaseFormData = JSON.parse(localStorage.getItem("purchaseFormData"));

// Extracting data from purchaseFormData
const data = [];

// Assuming purchaseFormData is an object with properties site, item, quantity, etc.
if (purchaseFormData) {
  const { site, item, quantity, productspecification, company, requester, technician } = purchaseFormData;
  const id = worksheet["A" + (worksheet["!ref"].split(":")[1].replace(/\D/g, "") * 1 + 1)]; // Generate ID based on row number
  data.push([id ? id.v + 1 : 1, site, item, quantity, productspecification, company, requester, technician]);
}

// Find the next available row in the "ORDERS" worksheet
let rowIndex = 2; // Assuming row 1 is for headers
while (worksheet["A" + rowIndex]) {
  rowIndex++;
}

// Insert purchase data into the worksheet starting from the next available row
data.forEach((rowData, i) => {
  rowData.forEach((cellData, j) => {
    worksheet[String.fromCharCode(65 + j) + rowIndex + i] = { v: cellData };
  });
});

// Write the modified workbook back to the file
XLSX.writeFile(workbook, "request.xlsx");
