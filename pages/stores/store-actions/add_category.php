<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$database = "portal_db"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = trim($_POST['category_name']);

    // Validate input
    if (empty($category_name)) {
        echo "<script>alert('Category name cannot be empty!'); window.history.back();</script>";
        exit;
    }

    // Insert into database without checking for duplicates
    $stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)");
    $stmt->bind_param("s", $category_name);

    if ($stmt->execute()) {
        echo "<script>
                window.location.href = document.referrer;
                alert('Category added successfully!');
            </script>";
    exit;
    }
     else {
        echo "<script>alert('Error adding category!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

