document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM loaded, calling loadStock()...");
    loadStockdata();
});

// Function to load stock data into the table
function loadStockdata() {
    fetch("pages/stores/store-actions/get_stock_details.php")
        .then(response => response.json())
        .then(data => {
            console.log("Received Data:", data);
           // console.log("Stock items count:", data.data.length); for debuging

            let stockBody = document.getElementById("stock_body");
            stockBody.innerHTML = "";

            if (data.success) {
                data.data.forEach((item, index) => {
                    stockBody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.created_at}</td>
                            <td>${item.name}</td>
                            <td>${item.category_name}</td>
                            <td>${item.description}</td>
                            <td>${item.unit_of_measure}</td>
                            <td>${item.quantity}</td>
                            <td>${item.price_per_unit}</td>
                            <td>${item.total_price}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm" onclick="editStock(${item.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteStock(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                stockBody.innerHTML = "<tr><td colspan='9'>No stock data available</td></tr>";
            }
        })
        .catch(error => {
            console.error("Error fetching stock data:", error);
            stockBody.innerHTML = "<tr><td colspan='9'>Failed to load stock data</td></tr>";
        });
}

// Function to submit or update stock data
document.getElementById("stockForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("pages/stores/store-actions/save_stock.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // ✅ Show success message
            alert("Stock item successfully saved!");

            // ✅ Close modal
            let modalElement = document.getElementById("stockModal");
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }

            // ✅ Wait for modal animation to complete before reloading
            setTimeout(() => {
                window.location.reload();
            }, 500); // Adjust timeout if needed
        }
    })
    .catch(error => console.error("Stock submission failed:", error));
});


// Function to edit stock details
function editStock(id) {
    console.log("Edit button clicked for Stock ID:", id);

    fetch(`pages/stores/store-actions/get_stock_details.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not OK. Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Full API Response:", data);

            if (data.success && Array.isArray(data.data)) {
                let item = data.data.find(stock => stock.id == id);

                if (!item) {
                    alert("Error: Stock item not found.");
                    return;
                }

                // Select form fields
                let elements = {
                    stockIdField: document.getElementById("stock_id"),
                    stockItemField: document.getElementById("stock_item"),
                    categoryField: document.getElementById("category_id"),
                    descriptionField: document.getElementById("description"),
                    quantityField: document.getElementById("quantity"),
                    unitMeasureField: document.getElementById("unit_of_measure"),
                    priceField: document.getElementById("price_per_unit"),
                    statusField: document.getElementById("status"),
                    modalTitle: document.getElementById("modal-title"),
                    submitButton: document.getElementById("newupdate"),
                    stockForm: document.getElementById("stockForm"),
                    modalElement: document.getElementById("stockModal")
                };

                // Check if any element is missing
                for (let key in elements) {
                    if (!elements[key]) {
                        console.error(`Missing element: ${key} - Check the ID in HTML`);
                    }
                }
                console.log("Form Elements:", elements);
                console.log("Missing Elements:", Object.entries(elements).filter(([key, value]) => value === null));


                // If any element is missing, stop execution
                if (Object.values(elements).includes(null)) {
                    alert("Error: Form elements missing. Please refresh the page.");
                    return;
                }

                // Populate the form fields
                elements.stockIdField.value = item.id || "";  
                elements.stockItemField.value = item.name || "";  
                elements.categoryField.value = item.category_id || "";
                elements.descriptionField.value = item.description || "";
                elements.quantityField.value = item.quantity || "";
                elements.unitMeasureField.value = item.unit_of_measure || "";
                elements.priceField.value = item.price_per_unit || "";
                elements.statusField.value = item.status || "";

                // Change modal title and button text
                elements.modalTitle.innerText = "Edit Stock";
                elements.submitButton.innerHTML = '<i class="fas fa-save"></i> Update Stock';

                // Show modal
                let modal = new bootstrap.Modal(elements.modalElement);
                modal.show();
            } else {
                alert("Error: Stock data is not valid.");
            }
        })
        .catch(error => {
            console.error("Error fetching stock details:", error);
            alert("Failed to load stock details. Please try again.");
        });
}





// Function to delete stock item
function deleteStock(id) {
    if (confirm("Are you sure you want to delete this stock item?")) {
        fetch(`pages/stores/store-actions/delete_stock.php?id=${id}`, { method: "DELETE" })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text(); // Read response as text
            })
            .then(text => {
                console.log("Raw Response:", text); // Debugging purpose
                return text ? JSON.parse(text) : {}; // Parse only if text exists
            })
            .then(data => {
                if (data.success) {
                    alert("Stock item deleted successfully!");
                    loadStockdata();
                } else {
                    alert("Error: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => console.error("Error deleting stock:", error));
    }
}

