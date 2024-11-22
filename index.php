<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Report Dashboard</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DateTimePicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.full.min.js"></script>

    <!-- DateTimePicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.min.css">

    <!-- External CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <style>
        /* Add CSS to position the button */
        .search-container {
            display: flex; /* Use flexbox for alignment */
            align-items: center; /* Center items vertically */
            margin-bottom: 20px; /* Space below the search container */
        }

        #downloadCsv {
            margin-left: 10px; /* Space between search input and download button */
            padding: 5px 10px; /* Padding for the button */
            background-color: #007BFF; /* Button background color */
            color: white; /* Button text color */
            text-decoration: none; /* Remove underline */
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        #downloadCsv:hover {
            background-color: #0056b3; /* Darker background on hover */
        }
    </style>
</head>
<body>

<h2>Activation Report</h2>
<!-- Search & Date Range Filter -->
<form id="searchForm">
    <input type="text" id="fromDate" name="fromDate" placeholder="From Date">
    <input type="text" id="toDate" name="toDate" placeholder="To Date">
    <button type="submit">Apply</button>
</form>

<div class="search-container">
    <label for="search">Search by:</label>
    <input type="text" name="search" id="search" placeholder="Search by name or department">
    <a href="download.php" target="_blank" id="downloadCsv">Download CSV</a>
</div>

<!-- Report Table -->
<div id="reportTable">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic Data will Load Here -->
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
<div id="pagination"></div>

<!-- JS -->
<script>
    // Initialize Date Picker
    $('#fromDate, #toDate').datetimepicker({ format: 'Y-m-d' });

    // Fetch Data with AJAX
    function fetchData(page = 1) {
        let formData = $('#searchForm').serialize() + '&page=' + page;
        $.ajax({
            url: 'fetch_data.php',
            type: 'GET',
            data: formData,
            success: function(response) {
                let data = JSON.parse(response);
                $('#reportTable tbody').html(data.table);
                $('#pagination').html(data.pagination);
            }
        });
    }

    // On Search Submit
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        fetchData();
    });

    // Handle Pagination Clicks
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        fetchData(page);
    });

    // Load Initial Data
    fetchData();

    // Optional: Confirm CSV Download
    $('#downloadCsv').on('click', function() {
        return confirm('Are you sure you want to download the CSV report?');
    });
</script>

</body>
</html>
