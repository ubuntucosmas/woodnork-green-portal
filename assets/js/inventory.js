
//function to upload form data to the inventory stock table in the db
function submitInventory(event) {
    event.preventDefault(); // Prevent default form submission

    // Collect form data
    let formData = new FormData(document.getElementById("inventoryForm"));

    // Send data to PHP using AJAX
    fetch("submit_inventory.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Convert response to JSON
    .then(data => {
        if (data.success) {
            alert("Inventory added successfully!");
            // Close the modal
            let modal = document.getElementById("inventoryModal");
            modal.style.display = "none";

            document.getElementById("inventoryForm").reset(); // Clear form

            // Reload page to update inventory list (Optional)
            location.reload();

            
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}

// Loading data from inventory table to the inventory table on the frontend
document.addEventListener("DOMContentLoaded", function () {
    loadInventory();
});

function loadInventory() {
    fetch("fetch_inventory.php")
        .then(response => response.json())
        .then(data => {
            console.log("Received Data:", data);
            let inventoryBody = document.getElementById("inventory_body");
            inventoryBody.innerHTML = "";

            if (data.success) {
                data.data.forEach((item, index) => {
                    inventoryBody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.date}</td>
                            <td>${item.make}</td>
                            <td>${item.model}</td>
                            <td>${item.serial}</td>
                            <td>${item.specs}</td>
                            <td>${item.user}</td>
                            <td>${item.cost}</td>
                            <td>${item.cond}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editInventory(${item.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteInventory(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                inventoryBody.innerHTML = "<tr><td colspan='10'>No inventory data available</td></tr>";
            }
        })
        .catch(error => {
            console.error("Error fetching inventory:", error);
            inventoryBody.innerHTML = "<tr><td colspan='10'>Failed to load inventory data</td></tr>";
        });
}

// Function to handle editing an inventory item
function editInventory(id) {
    console.log("Edit button clicked for ID:", id); // Debugging

    fetch(`edit_inventory.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            console.log("Received Data:", data); // Debugging

            if (data.success && data.data) {
                let item = data.data;

                document.getElementById("date").value = item.date || "";
                document.getElementById("make").value = item.make || "";
                document.getElementById("model").value = item.model || "";
                document.getElementById("serial").value = item.serial || "";
                document.getElementById("specs").value = item.specs || "";
                document.getElementById("user").value = item.user || "";
                document.getElementById("cost").value = item.cost || "";
                document.getElementById("condition").value = item.cond || "";

                document.getElementById("modalTitle").innerText = "Edit Inventory";

                // Store item ID properly
                // document.getElementById("inventoryId").value = id;

                // Show the modal
                let modal = new bootstrap.Modal(document.getElementById("inventoryModal"));
                modal.show();
            } else {
                alert("Error: Inventory item not found.");
            }
        })
        .catch(error => {
            console.error("Error fetching inventory item:", error);
            alert("Failed to load inventory details. Please try again.");
        });
}

//JavaScript to pass the inventory ID when submitting the form

document.getElementById("inventoryForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const inventoryId = document.getElementById("inventory_id").value;
    const formData = new FormData(document.getElementById("inventoryForm"));

    let url = inventoryId ? `edit_inventory.php?id=${inventoryId}` : "add_inventory.php";
    let method = inventoryId ? "PUT" : "POST";

    fetch(url, {
        method: method,
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            document.getElementById("inventoryForm").reset();
            document.getElementById("inventory_id").value = ""; // Reset hidden input
            loadInventory(); // Reload table
            let modal = bootstrap.Modal.getInstance(document.getElementById("inventoryModal"));
            modal.hide();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});




// Function to handle deleting an inventory item
function deleteInventory(id) {
    if (confirm("Are you sure you want to delete this inventory item?")) {
        fetch(`delete_inventory.php?id=${id}`, { method: "DELETE" })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Inventory deleted successfully!");
                    loadInventory(); // Reload inventory table
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(error => console.error("Error deleting inventory:", error));
    }
}


