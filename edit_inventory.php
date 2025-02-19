<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_db";

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM inventory WHERE id = ?");
$query->execute([$id]);

$item = $query->fetch(PDO::FETCH_ASSOC);
if ($item) {
    echo json_encode(["success" => true, "data" => $item]);
} else {
    echo json_encode(["success" => false, "message" => "Item not found"]);
}
?>
