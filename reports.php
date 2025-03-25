<?php
session_start(); // Start the session to check login status
require 'connectdb.php'; // Ensure this initializes a PDO connection in $db
require 'report_functions.php';
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$salesData = getSalesData($db);
$topProducts = getTopSellingProducts($db);
$stats = getOrderStatistics($db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="reports.css">
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <div class="dashboard-container">
        <h2>Reports & Analytics</h2>

        <div class="report-section">
            <h3>Sales Reports</h3>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Report Type</th>
                        <th>Time Period</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sales Summary</td>
                        <td>Last 30 Days</td>
                        <td><button id="viewReportBtn">View Report</button></td>
                    </tr>


                    <tr>
                        <td>Top Selling Products</td>
                        <td>Last 6 Months</td>
                        <form action="export_pdf.php" method="post">
                            <td><button type="submit">Download PDF</button></td>
                        </form>
                    </tr>
                    <tr>
                        <td>Customer Orders</td>
                        <td>Last Year</td>
                        <form action="export_excel.php" method="post">
                            <td><button type="submit">Export to Excel</button></td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="reportModal" class="modal" display: none;>
            <div class="modal-content">
                <button class="close-btn" onclick="closeModal()">X</button>
                <h2>Sales Summary</h2>
                <div id="salesSummary">
                    <p>Loading sales data...</p>
                </div>
            </div>
        </div>

        <div class="report-section">
            <h3>Order Statistics</h3>
            <div class="stats-container">
                <div class="stat-box">
                    <h4>Total Orders</h4>
                    <p><?= $stats['total_orders'] ?></p>
                </div>
                <div class="stat-box">
                    <h4>Pending Orders</h4>
                    <p><?= $stats['pending_orders'] ?></p>
                </div>
                <div class="stat-box">
                    <h4>Shipped Orders</h4>
                    <p><?= $stats['shipped_orders'] ?></p>
                </div>
                <div class="stat-box">
                    <h4>Cancelled Orders</h4>
                    <p><?= $stats['cancelled_orders'] ?></p>
                </div>
            </div>
        </div>

        <div class="report-section">
            <h3>Revenue Overview</h3>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($stats['dates']); ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?php echo json_encode($stats['revenues']); ?>,
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('reportModal').style.display = 'none';
        });

        // Open modal
        document.getElementById('viewReportBtn').addEventListener('click', function () {
            document.getElementById('reportModal').style.display = 'block';
            fetchSalesData(); // Fetch sales data when modal opens
        });

        // Close modal
        function closeModal() {
            document.getElementById('reportModal').style.display = 'none';
        }

        // Fetch and load sales summary via AJAX
        function fetchSalesData() {
            $.ajax({
                url: 'fetch_sales_summary.php', // PHP file to fetch sales data
                type: 'GET',
                success: function (data) {
                    $('#salesSummary').html(data); // Insert fetched data into modal
                },
                error: function () {
                    $('#salesSummary').html('<p>Error loading sales data.</p>');
                }
            });
        }
    </script>

</body>

</html>