
// js for selecting multiple items of the dispatch form
$(document).on("click", "#add_item", function () {
    $.ajax({
        url: "pages/stores/store-actions/get_stock.php", // Fetch stock items dynamically
        method: "GET",
        dataType: "json", // Ensure response is treated as JSON
        success: function (data) {
            console.log(data); // Debugging: Check if data is received correctly

            let options = '<option value="">Select Item</option>'; // Default option
            $.each(data, function (index, item) {
                options += `<option value="${item.id}">${item.name}</option>`; // Append fetched items
            });

            let itemGroup = `
                <div class="item-group d-flex align-items-center mt-2">
                    <select name="items[]" class="form-control me-2" required>
                        ${options} <!-- Fetched stock items -->
                    </select>
                    <input type="number" name="quantities[]" class="form-control me-2" min="1" required>
                    <button type="button" class="btn btn-danger remove-item">X</button>
                </div>`;

            $("#stock_items").append(itemGroup);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching stock:", error); // Debugging error
        }
    });
});

// Remove item field dynamically
$(document).on("click", ".remove-item", function () {
    $(this).closest(".item-group").remove();
});



document.getElementById("dispatch_form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    // Open receipt in a new full-page window
    const formAction = this.action + "?" + new URLSearchParams(new FormData(this)).toString();
    window.open(formAction, "_blank", "noopener,noreferrer");

    // Delay reloading stock_allocation.php for 2 seconds
    setTimeout(() => {
        window.location.href = "stock_allocation.php";
    }, 2);
});
