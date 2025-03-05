<?php
session_start(); // Start the session to check login status
require 'connectdb.php'; // Ensure this initializes a PDO connection in $db
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="reports.css">
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
                        <td><button>View Report</button></td>
                    </tr>
                    <tr>
                        <td>Top Selling Products</td>
                        <td>Last 6 Months</td>
                        <td><button>Download PDF</button></td>
                    </tr>
                    <tr>
                        <td>Customer Orders</td>
                        <td>Last Year</td>
                        <td><button>Export to Excel</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="report-section">
            <h3>Order Statistics</h3>
            <div class="stats-container">
                <div class="stat-box">
                    <h4>Total Orders</h4>
                    <p>1,250</p>
                </div>
                <div class="stat-box">
                    <h4>Pending Orders</h4>
                    <p>35</p>
                </div>
                <div class="stat-box">
                    <h4>Shipped Orders</h4>
                    <p>1,180</p>
                </div>
                <div class="stat-box">
                    <h4>Cancelled Orders</h4>
                    <p>20</p>
                </div>
            </div>
        </div>
        
        <div class="report-section">
            <h3>Revenue Overview</h3>
            <div class="chart-container">
                <p>[Graph Placeholder]</p>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>

