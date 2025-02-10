

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

function closeStockModal() {
    let modal = document.getElementById("stockModal");
    if (modal) {
        modal.style.animation = "fadeOut 0.3s ease-in-out"; // Add fade-out animation
        setTimeout(() => {
            modal.style.display = "none"; // Hide modal after animation
        }, 300);
    }
}

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

document.getElementById("stockForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let stock_id = document.getElementById("stock_id").value;
    let item_name = document.getElementById("item_name").value;
    let quantity = document.getElementById("quantity").value;
    let category = document.getElementById("category").value;

    let formData = new FormData();
    formData.append("stock_id", stock_id);
    formData.append("item_name", item_name);
    formData.append("quantity", quantity);
    formData.append("category", category);

    fetch('pages/save_stock.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        closeStockModal();
        loadStockData();
    })
    .catch(error => console.error('Error saving stock:', error));
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
function loadStockData() {
    fetch('pages/get_stock.php')
        .then(response => response.json())
        .then(data => {
            let stockTable = document.getElementById("stock_body");
            stockTable.innerHTML = "";

            if (data.length > 0) {
                data.forEach((stock, index) => {
                    stockTable.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${stock.item_name}</td>
                            <td>${stock.quantity}</td>
                            <td>${stock.category}</td>
                            <td>
                                <button onclick="editStock(${stock.id}, '${stock.item_name}', ${stock.quantity}, '${stock.category}')">Edit</button>
                                <button onclick="deleteStock(${stock.id})">Delete</button>
                            </td>
                        </tr>`;
                });
            } else {
                stockTable.innerHTML = `<tr><td colspan="5">No stock available.</td></tr>`;
            }
        })
        .catch(error => console.error('Error fetching stock:', error))
        .finally(() => {
            hideLoadingSpinner(); // Hide spinner after fetching data
        });
}
// Show confirmation message
function showConfirmationMessage(message) {
    const confirmationDiv = document.createElement("div");
    confirmationDiv.className = "confirmation-message";
    confirmationDiv.innerText = message;
    document.body.appendChild(confirmationDiv);

    setTimeout(() => {
        confirmationDiv.remove(); // Remove message after 3 seconds
    }, 3000);
}
loadStockData();

function exportStock(type) {
    window.location.href = `pages/export_stock.php?type=${type}`;
}
