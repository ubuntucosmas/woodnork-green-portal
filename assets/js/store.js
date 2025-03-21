

function openStockModal(isEdit = false, stockData = null) {
    let modal = document.getElementById("stockModal");
    modal.style.display = "flex"; // Keep centered display
    modal.style.animation = "fadeIn 0.3s ease-in-out"; // Add animation

    if (isEdit && stockData) {
        document.getElementById("modalTitle").innerText = "Edit Stock";
        document.getElementById("stock_id").value = stockData.id;
        document.getElementById("item_name").value = stockData.item_name;
        document.getElementById("quantity").value = stockData.quantity;
        document.getElementById("category").value = stockData.category;
    } else {
        document.getElementById("modalTitle").innerText = "Add Stock";
        document.getElementById("stockForm").reset();
        document.getElementById("stock_id").value = "";
    }
}
//stock modakl
function closeStockModal() {
    let modal = document.getElementById("stockModal");
    if (modal) {
        modal.style.animation = "fadeOut 0.3s ease-in-out"; // Add fade-out animation
        setTimeout(() => {
            modal.style.display = "none"; // Hide modal after animation
        }, 300);
    }
}
//stock allocation modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("dispatchModal");
    const closeButton = document.querySelector(".x");

    // Close modal when the close button is clicked
    closeButton.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Close modal when clicking outside the modal content
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});


function editStock(id, name, quantity, category) {
    openStockModal(true, { id, item_name: name, quantity, category });
}

function deleteStock(id) {
    if (confirm("Are you sure you want to delete this stock item?")) {
        fetch(`pages/stores/store-actions/delete_stock.php?id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                loadStockData();
            })
            .catch(error => console.error('Error deleting stock:', error));
    }
}

document.addEventListener("DOMContentLoaded", function () {
    function initializeStockForm() {
        var stockForm = document.getElementById("stockForm");

        if (stockForm) {
            console.log("Status value before submit:", document.getElementById("status").value);

            stockForm.addEventListener("submit", function(event) {
                event.preventDefault();
                

                var formData = new FormData(stockForm);
                console.log("Sending data:", Object.fromEntries(formData.entries())); // for Debugging

                fetch("pages/stores/store-actions/save_stock.php", {  // Adjust the path based on your project structure
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Server Response:", data); // Debugging: Check response from PHP
                    alert(data); // Show response in an alert
                    stockForm.reset(); // Clear form fields
                    fetchStockData(); // Refresh data dynamically
                    closeStockModal(); // Close the modal after successful submission
                    location.reload();

                })
                .catch(error => console.error("Error:", error));
            });
        } else {
            console.error("Error: stockForm element not found. Maybe it's being loaded dynamically?");
        }
    }

    // Check every 1 second if stockForm is available
    var interval = setInterval(function () {
        if (document.getElementById("stockForm")) {
            clearInterval(interval); // Stop checking
            initializeStockForm(); // Initialize form
        }
    }, 1000);
});



// Ensure clicking outside **does NOT** close the modal
document.getElementById("stockModal").addEventListener("click", function(event) {
    let modalContent = document.querySelector(".modal-content");
    if (!modalContent.contains(event.target)) {
        event.stopPropagation(); // Prevent modal from closing
    }
});

// Ensure close button works
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".close").addEventListener("click", closeStockModal);
});
// Show/hide loading spinner
function showLoadingSpinner() {
    document.getElementById("loadingSpinner").style.display = "block";
}

function hideLoadingSpinner() {
    document.getElementById("loadingSpinner").style.display = "none";
}





function exportStock(type) {
    window.location.href = `pages/stores/store-actions/export_stock.php?type=${type}`;
}


function exportStock(type) {
    window.location.href = `pages/stores/store-actions/export_stock.php?type=${type}`;
}





// Function to format date for better readability
function formatDate(dateStr) {
    let date = new Date(dateStr);
    return date.toLocaleDateString('en-GB'); // Format: DD/MM/YYYY
}


//closing and opening the stock allocation modal

// Function to open the modal
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "flex";
}

// Function to close the modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// Close the modal when the user clicks anywhere outside of it
window.onclick = function(event) {
    var modal = document.getElementById('dispatchModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    var operationSelect = document.getElementById("operation");
    var statusInput = document.getElementById("status");

    operationSelect.addEventListener("change", function () {
        if (operationSelect.value === "add") {
            statusInput.value = "in";  // Stock coming in
        } else {
            statusInput.value = "out"; // Stock going out
        }
        console.log("Status set to:", statusInput.value); // Debugging
    });
});


// Search and filter


// document.addEventListener("DOMContentLoaded", function () {
//      // Load initial data
// });

// function loadSearchData() {
//     let searchItem = document.getElementById("search_item").value.toLowerCase();
//     let filterType = document.getElementById("filter_type").value;
//     let filterDate = document.getElementById("filter_date").value;

//     let inventoryBody = document.getElementById("inventory_body");

//     fetch("pages/stores/store-actions/get_stock.php") // Adjust this path if needed
//         .then(response => response.json())
//         .then(data => {
//             // console.log("Received Data:", data); for debuging
//             if (data.success) {
//                 let filteredData = data.data.filter(item => {
//                     let matchItem = item.name.toLowerCase().includes(searchItem);
//                     let matchType = filterType === "" || item.type === filterType;
//                     let matchDate = filterDate === "" || item.date === filterDate;
                    
//                     return matchItem && matchType && matchDate;
//                 });

//                 let inventoryHTML = "";

//                 if (filteredData.length > 0) {
//                     filteredData.forEach((item, index) => {
//                         inventoryHTML += `
//                             <tr>
//                                 <td>${index + 1}</td>
//                                 <td>${item.date}</td>
//                                 <td>${item.name}</td>
//                                 <td>${item.type}</td>
//                                 <td>${item.quantity}</td>
//                                 <td><button class="btn btn-sm btn-danger" onclick="deleteItem(${item.id})">Delete</button></td>
//                             </tr>
//                         `;
//                     });
//                 } else {
//                     inventoryHTML = "<tr><td colspan='6' class='text-center'>No matching results found</td></tr>";
//                 }

//                 inventoryBody.innerHTML = inventoryHTML;
//             } else {
//                 inventoryBody.innerHTML = "<tr><td colspan='6'>No inventory data available</td></tr>";
//             }
//         })
//         .catch(error => {
//             console.error("Error fetching inventory:", error);
//             inventoryBody.innerHTML = "<tr><td colspan='6'>Failed to load inventory data</td></tr>";
//         });
// }



document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("lowStockTrigger").addEventListener("click", function () {
        fetch("pages/stores/store-actions/low_stock_alert_fetch.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                let tableBody = document.getElementById("lowStockTableBody");
                tableBody.innerHTML = ""; // Clear existing rows

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No low stock items found.</td></tr>';
                } else {
                    data.forEach(item => {
                        let row = `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.category_id}</td>
                                <td>${item.description}</td>
                                <td>${item.quantity}</td>
                                <td>${item.unit_of_measure}</td>
                                <td>${item.price_per_unit}</td>
                                <td>${item.total_price}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching low stock items:", error);
                alert("Failed to fetch low stock items.");
            });
    });
});




