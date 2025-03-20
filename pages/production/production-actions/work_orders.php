<?php
require '../includes/db.php'; // Ensure this file connects to your database

header('Content-Type: application/json');

// Fetch all work orders
$sql = "SELECT * FROM work_orders ORDER BY created_at DESC";
$result = $conn->query($sql);

$workOrders = [];
while ($row = $result->fetch_assoc()) {
    $workOrders[] = $row;
}

echo json_encode($workOrders);
?>

<?php
require '../includes/db.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Work order ID required']);
    exit;
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM work_orders WHERE work_order_id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'Work order not found']);
}
?>

<?php
require '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$work_order_id = uniqid('WO'); // Generate unique work order ID
$project_name = $conn->real_escape_string($data['project_name']);
$assigned_to = $conn->real_escape_string($data['assigned_to']);
$priority = $conn->real_escape_string($data['priority']);
$start_date = $conn->real_escape_string($data['start_date']);
$due_date = $conn->real_escape_string($data['due_date']);
$status = $conn->real_escape_string($data['status']);
$description = $conn->real_escape_string($data['description']);

$sql = "INSERT INTO work_orders (work_order_id, project_name, assigned_to, priority, start_date, due_date, status, description) 
        VALUES ('$work_order_id', '$project_name', '$assigned_to', '$priority', '$start_date', '$due_date', '$status', '$description')";

if ($conn->query($sql)) {
    echo json_encode(['success' => 'Work order created', 'work_order_id' => $work_order_id]);
} else {
    echo json_encode(['error' => $conn->error]);
}
?>

<?php
require '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['id'])) {
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$id = $conn->real_escape_string($data['id']);
$project_name = $conn->real_escape_string($data['project_name']);
$assigned_to = $conn->real_escape_string($data['assigned_to']);
$priority = $conn->real_escape_string($data['priority']);
$start_date = $conn->real_escape_string($data['start_date']);
$due_date = $conn->real_escape_string($data['due_date']);
$status = $conn->real_escape_string($data['status']);
$description = $conn->real_escape_string($data['description']);

$sql = "UPDATE work_orders 
        SET project_name='$project_name', assigned_to='$assigned_to', priority='$priority', 
            start_date='$start_date', due_date='$due_date', status='$status', description='$description'
        WHERE work_order_id='$id'";

if ($conn->query($sql)) {
    echo json_encode(['success' => 'Work order updated']);
} else {
    echo json_encode(['error' => $conn->error]);
}
?>

<?php
require '../includes/db.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Work order ID required']);
    exit;
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "DELETE FROM work_orders WHERE work_order_id = '$id'";

if ($conn->query($sql)) {
    echo json_encode(['success' => 'Work order deleted']);
} else {
    echo json_encode(['error' => $conn->error]);
}
?>
