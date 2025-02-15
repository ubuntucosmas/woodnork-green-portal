

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
        fetch(`pages/delete_stock.php?id=${id}`, { method: 'DELETE' })
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
            stockForm.addEventListener("submit", function(event) {
                event.preventDefault();

                var formData = new FormData(stockForm);

                console.log("Sending data:", Object.fromEntries(formData.entries())); // Debugging

                fetch("pages/save_stock.php", {  // Adjust the path based on your project structure
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


// Keep checking if the stock management page is loaded


function exportStock(type) {
    window.location.href = `pages/export_stock.php?type=${type}`;
}


function exportStock(type) {
    window.location.href = `pages/export_stock.php?type=${type}`;
}


function loadStoreData() {
    let item = document.getElementById("search_item").value;
    let type = document.getElementById("filter_type").value;
    let date = document.getElementById("filter_date").value;

    // Show loading state
    document.getElementById("total_stock").innerText = "Loading...";
    document.getElementById("low_stock").innerText = "Loading...";
    document.getElementById("recent_transactions").innerText = "Loading...";
    document.getElementById("transactions_body").innerHTML = `<tr><td colspan="5">Loading...</td></tr>`;

    fetch("pages/store_overview.php")
    .then(response => response.json())
    .then(data => {
        document.getElementById("total_stock").innerText = data.total_stock;
        document.getElementById("low_stock").innerText = data.low_stock;
        document.getElementById("recent_transactions").innerText = data.recent_transactions;

        let transactionsTable = document.getElementById("transactions_body");
        transactionsTable.innerHTML = "";

        if (data.transactions.length > 0) {
            data.transactions.forEach((item, index) => {
                transactionsTable.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.item_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit_of_measure}</td>
                        <td>${formatDate(item.created_at)}</td>
                    </tr>`;
            });
        } else {
            transactionsTable.innerHTML = `<tr><td colspan="5">No stock items found.</td></tr>`;
        }
    })
    .catch(error => {
        console.error("Error fetching store data:", error);
        document.getElementById("transactions_body").innerHTML = `<tr><td colspan="5">Failed to load data.</td></tr>`;
    });


}
// Load data on page load
document.addEventListener("DOMContentLoaded", function () {
    loadStoreData();
});


// Function to format date for better readability
function formatDate(dateStr) {
    let date = new Date(dateStr);
    return date.toLocaleDateString('en-GB'); // Format: DD/MM/YYYY
}



