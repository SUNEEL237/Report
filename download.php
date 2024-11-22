<?php
include 'includes/db_connect.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="report.csv"');
$filename = "activation_report_" . date('Ymd') . ".csv";

// Set headers to trigger file download
header('Content-Disposition: attachment; filename="' . $filename . '"');
$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Name', 'Department', 'Date', 'Amount']);

$query = "SELECT * FROM reports";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
?>
