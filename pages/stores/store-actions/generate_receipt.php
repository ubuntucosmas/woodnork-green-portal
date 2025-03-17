<?php
ob_start();
require __DIR__ . '/../../../vendor/autoload.php';
use TCPDF;

// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "portal_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Retrieve and sanitize input
$dispatch_id = $_GET['dispatch_id'] ?? 'Unknown';
$project_name = $_GET['project_name'] ?? 'N/A';
$destination = $_GET['destination'] ?? 'N/A';
$dispatcher = $_GET['dispatcher'] ?? 'N/A';
$receiver = $_GET['receiver'] ?? 'N/A';

// Fetch dispatch details
$stmt = $pdo->prepare("
    SELECT d.stock_id, d.quantity, s.name AS stock_name, s.description 
    FROM dispatches d 
    JOIN stock s ON d.stock_id = s.id 
    WHERE d.dispatch_id = ?
");
$stmt->execute([$dispatch_id]);
$dispatches = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$dispatches) {
    die("No dispatch records found.");
}

// Initialize PDF
$pdf = new TCPDF();
$pdf->SetTitle("WoodNorkGreen Dispatch Receipt");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Company Branding & Header
$html = "
    <div style='text-align: center;'>
        <h1 style='color: #145DA0;'>WoodNorkGreen</h1>
        <p style='font-size: 14px; color: #555;'>Sustainable Stock Management</p>
    </div>
    <hr style='border: 2px solid #2E8BC0;'>
    
    <h2 style='text-align: center; color: #0C2D48;'>Dispatch Receipt</h2>
    <table style='width: 100%;'>
        <tr>
            <td style='width: 50%;'><strong>Dispatch ID:</strong> $dispatch_id</td>
            <td style='width: 50%; text-align: right;'><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</td>
        </tr>
        <tr>
            <td><strong>Project:</strong> $project_name</td>
            <td style='text-align: right;'><strong>Destination:</strong> $destination</td>
        </tr>
        <tr>
            <td><strong>Dispatcher:</strong> $dispatcher</td>
            <td style='text-align: right;'><strong>Receiver:</strong> $receiver</td>
        </tr>
    </table>
    <hr style='border: 1px solid #2E8BC0; margin-top: 10px;'>
    
    <h3 style='color: #145DA0; text-align: center;'>Dispatched Items</h3>
    <table style='border-collapse: collapse; width: 100%; font-size: 12px;'>
        <thead>
            <tr style='background-color: #145DA0; color: white;'>
                <th style='border: 1px solid #ddd; padding: 8px;'>Stock ID</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Stock Name</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Description</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Quantity</th>
            </tr>
        </thead>
        <tbody>";

foreach ($dispatches as $row) {
    $html .= "
            <tr style='background-color: #f2f2f2;'>
                <td style='border: 1px solid #ddd; padding: 8px;'>{$row['stock_id']}</td>
                <td style='border: 1px solid #ddd; padding: 8px;'>{$row['stock_name']}</td>
                <td style='border: 1px solid #ddd; padding: 8px;'>{$row['description']}</td>
                <td style='border: 1px solid #ddd; padding: 8px; text-align: center;'>{$row['quantity']}</td>
            </tr>";
}

$html .= "
        </tbody>
    </table>
    <br><br>
    
    <hr style='border: 1px solid #2E8BC0;'>
    <table style='width: 100%; text-align: center; font-size: 12px; margin-top: 20px;'>
        <tr>
            <td style='width: 50%; text-align: left;'>
                <p><strong>Approved By:</strong></p>
                <p>________________________</p>
                <p style='color: #555;'>Manager Signature</p>
            </td>
            <td style='width: 50%; text-align: right;'>
                <p><strong>Received By:</strong></p>
                <p>________________________</p>
                <p style='color: #555;'>Recipient Signature</p>
            </td>
        </tr>
    </table>
    <hr style='border: 2px solid #145DA0; margin-top: 30px;'>
    <p style='text-align: center; font-size: 11px; color: #777;'>WoodNorkGreen &copy; " . date('Y') . " - All Rights Reserved.</p>
";

// Generate PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("dispatch_receipt_$dispatch_id.pdf", 'I');

ob_end_flush();
?>
