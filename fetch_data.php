<?php
include 'includes/db_connect.php';

// Pagination Variables
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search Filters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

// Build Query with Filters
$query = "SELECT * FROM reports WHERE 1";
if ($search) {
    $query .= " AND (name LIKE '%$search%' OR department LIKE '%$search%')";
}
if ($fromDate && $toDate) {
    $query .= " AND date BETWEEN '$fromDate' AND '$toDate'";
}
$query .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($query);

// Fetch Data
$table = '';
while ($row = $result->fetch_assoc()) {
    $table .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['department']}</td>
        <td>{$row['date']}</td>
        <td>{$row['amount']}</td>
    </tr>";
}

// Pagination Links
$totalRows = $conn->query("SELECT COUNT(*) as count FROM reports")->fetch_assoc()['count'];
$totalPages = ceil($totalRows / $limit);
$pagination = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $pagination .= "<a href='#' class='page-link' data-page='$i'>$i</a> ";
}

// Response
$response = ['table' => $table, 'pagination' => $pagination];
echo json_encode($response);
?>
