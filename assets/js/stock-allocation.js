$(document).ready(function () {
    $("#add_item").click(function () {
        let newItem = `
            <div class="item-group">
                <select name="items[]" required>
                    <option value="">Select Item</option>
                    <?php
                    require '../config/database.php';
                    $stock_result = $conn->query("SELECT id, name FROM stock WHERE quantity > 0");
                    while ($row = $stock_result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
                <input type="number" name="quantities[]" min="1" required>
                <button type="button" class="remove-item">X</button>
            </div>
        `;
        $("#stock_items").append(newItem);
    });

    $(document).on("click", ".remove-item", function () {
        $(this).parent().remove();
    });
});
