<?php
include '../includes/db.php';

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $query = $conn->prepare("DELETE FROM stock WHERE id=?");
    $query->bind_param("i", $id);

    if ($query->execute()) {
        echo json_encode(["message" => "Stock deleted successfully!"]);
    } else {
        echo json_encode(["message" => "Error deleting stock."]);
    }
}
?>
