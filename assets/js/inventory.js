
//function to upload form data to the inventory stock table in the db
function submitInventory(event) {
    event.preventDefault(); // Prevent default form submission

    let form = document.getElementById("inventoryForm");
    let formData = new FormData(form);
    
    let inventoryId = document.getElementById("inventory_id").value; 
    let url = inventoryId ? `pages/stores/store-actions/update_inventory.php` : `pages/stores/store-actions/submit_inventory.php`; // Update if ID exists

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Inventory saved successfully!");
            location.reload(); // Reload to reflect changes
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}

// Loading data from inventory table to the inventory table on the frontend
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM loaded, calling loadInventory()...");
    loadInventory();
});


function loadInventory() {
    fetch("pages/stores/store-actions/fetch_inventory.php")
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
                                <button class="btn btn-outline-primary btn-sm" onclick="editInventory(${item.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteInventory(${item.id})">
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

}

// Function to handle editing an inventory item
function editInventory(id) {
    console.log("Edit button clicked for ID:", id); // Debugging

    fetch(`pages/stores/store-actions/edit_inventory.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            

            if (data.success && data.data) {
                console.log("Received Data:", data); // Debugging
                let item = data.data;
                console.log("Received Data:", item.make); // Debugging

                document.getElementById("date").value = item.date || "";
                document.getElementById("make").value = item.make || "";
                document.getElementById("model").value = item.model || "";
                document.getElementById("serial").value = item.serial || "";
                document.getElementById("specs").value = item.specs || "";
                document.getElementById("user").value = item.user || "";
                document.getElementById("cost").value = item.cost || "";
                document.getElementById("condition").value = item.cond || "";

                document.getElementById("modalTitle").innerText = "Edit Inventory";
                document.getElementById("newupdate").innerText = "Update Inventory";

                // ✅ Store the inventory ID properly in a hidden field
                document.getElementById("inventory_id").value = id;

                // ✅ Ensure modal is properly initialized and shown
                let modalElement = document.getElementById("inventoryModal");
                let modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
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


// Function to handle deleting an inventory item
function deleteInventory(id) {
    if (confirm("Are you sure you want to delete this inventory item?")) {
        fetch(`pages/stores/store-actions/delete_inventory.php?id=${id}`, { method: "DELETE" })
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


