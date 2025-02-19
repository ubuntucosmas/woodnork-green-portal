
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
            
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}

// Loading data from inventory table to the inventory table on the frontend
document.addEventListener("DOMContentLoaded", function () {
    setInterval(loadInventory, 100);
});

function loadInventory() {
    
    fetch("fetch_inventory.php")
        .then(response => response.json())
        .then(data => {
            // console.log("Received Data:", data); // Log received data
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
                        </tr>
                    `;
                });

            } else {
                inventoryBody.innerHTML = "<tr><td colspan='9'>No inventory data available</td></tr>";
            }
        })
        .catch(error => {
            console.error("Error fetching inventory:", error);
            inventoryBody.innerHTML = "<tr><td colspan='9'>Failed to load inventory data</td></tr>";
        });
}


