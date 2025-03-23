<?php
require_once("connectdb.php");

// Handle accept order
if (isset($_POST['acceptOrder']) && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    try {
        // Update order status to 'Shipped'
        $stmt = $db->prepare("UPDATE Purchased SET order_status = 'Shipped' WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        echo "Order accepted and status updated to 'Shipped'.";
    } catch (PDOException $e) {
        echo "Error updating order: " . $e->getMessage();
    }

    exit;
}

// Handle cancel order
if (isset($_POST['cancelOrder']) && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    try {
        // Delete order from database
        $stmt = $db->prepare("DELETE FROM Purchased WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        echo "Order cancelled and removed from the system.";
    } catch (PDOException $e) {
        echo "Error canceling order: " . $e->getMessage();
    }

    exit;
}

function displayOrders($orders){
    foreach ($orders as $order) {
        echo "<tr>
                <td>" . htmlspecialchars($order['order_id']) . "</td>
                <td>" . htmlspecialchars($order['order_date']) . "</td>
                <td>" . htmlspecialchars($order['customer']) . "</td>
                <td>" . htmlspecialchars($order['items']) . "</td>
                <td>£" . number_format($order['total'], 2) . "</td>";

        // Process the status correctly
        $status = strtolower(trim(htmlspecialchars($order['status'])));

        if ($status == 'pending') {
            echo "<td><span class='status-badge status-pending'>" . htmlspecialchars($order['status']) . "</span></td>
            <td class='actions'>
                <button class='btn-success' title='Accept Order' onclick='acceptOrder(\"" . htmlspecialchars($order['order_id']) . "\")'>Accept</button>
                <button class='btn-danger' title='Cancel Order' onclick='cancelOrder(\"" . htmlspecialchars($order['order_id']) . "\")'>Cancel</button>
            </td>
            </tr>";
        } else {
            echo "<td><span class='status-badge status-processing'>" . htmlspecialchars($order['status']) . "</span></td>
            <td>
                <select id='changeStatus-" . htmlspecialchars($order['order_id']) . "' class='status-dropdown' onchange='changeOrderStatus(\"" . htmlspecialchars($order['order_id']) . "\")'>
                    <option value='shipped'>Shipped</option>
                    <option value='delivered'>Delivered</option>
                </select>
            </td>
            <td class='actions'>
                <button class='btn-success' title='Save Changes' onclick='saveChanges(\"" . htmlspecialchars($order['order_id']) . "\")'>Save Changes</button>
                <button class='btn-danger' title='Cancel' onclick='cancelOrder(\"" . htmlspecialchars($order['order_id']) . "\")'>Cancel</button>
            </td>";
        }
    }
}


function fetchPendingOrders($db) {
    try {
        $stmt = $db->prepare("
            SELECT p.order_id, DATE(p.time_of_order) AS order_date, u.full_name AS customer, 
                GROUP_CONCAT(pr.name SEPARATOR ', ') AS items, 
                o.total_price AS total, p.order_status AS status 
            FROM Purchased p
            JOIN Orders o ON p.order_id = o.order_id  -- Get total_price from Orders
            JOIN Users u ON o.email = u.email  -- Get customer name
            JOIN Products pr ON p.product_id = pr.product_id  -- Get product names
            WHERE p.order_status = 'Pending'
            GROUP BY p.order_id
            ORDER BY p.time_of_order DESC
        ");
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        displayOrders($orders);
    } catch (PDOException $e) {
        echo "Error fetching data: " . $e->getMessage();
    }
}

function fetchAcceptedOrders($db){
    try {
        $stmt = $db->prepare("
            SELECT p.order_id, DATE(p.time_of_order) AS order_date, u.full_name AS customer, 
                GROUP_CONCAT(pr.name SEPARATOR ', ') AS items, 
                o.total_price AS total, p.order_status AS status 
            FROM Purchased p
            JOIN Orders o ON p.order_id = o.order_id  -- Get total_price from Orders
            JOIN Users u ON o.email = u.email  -- Get customer name
            JOIN Products pr ON p.product_id = pr.product_id  -- Get product names
            WHERE p.order_status = 'Shipped'
            GROUP BY p.order_id
            ORDER BY p.time_of_order DESC
        ");
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        displayOrders($orders);
    } catch (PDOException $e) {
        echo "Error fetching data: " . $e->getMessage();
    }
}

// Handle AJAX request
if (isset($_GET['fetchOrders'])) {
    fetchPendingOrders($db);
    exit;
}

// Fetch orders for normal page load
ob_start();
fetchPendingOrders($db);
$pendingOrdersHTML = ob_get_clean();

ob_start();
fetchAcceptedOrders($db);
$acceptedOrdersHTML = ob_get_clean();
?>

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order Processing</title>
    <link rel="stylesheet" href="ProcessOrder.css">
    <link rel="stylesheet" href="main.css"> 
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head>
<body>
    <?php include 'Navbar.php'; ?> 

    <div class="container">
        <div class="header">
            <h1>Order Processing</h1>
            <div>
                <button id="refreshBtn">Refresh Data</button>
            </div>
        </div>
        
        <div class="filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="statusFilter">Status</label>
                    <select id="statusFilter">
                        <option value="all">All Orders</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="orderIdFilter">Order ID</label>
                    <input type="text" id="orderIdFilter" placeholder="Search by Order ID">
                </div>
                
                <div class="filter-group">
                    <label for="customerFilter">Customer</label>
                    <input type="text" id="customerFilter" placeholder="Search by customer name">
                </div>
                
                <div class="filter-group">
                    <label for="dateFilter">Date Range</label>
                    <div style="display: flex; gap: 5px;">
                        <input type="date" id="dateFromFilter">
                        <input type="date" id="dateToFilter">
                    </div>
                </div>
                
                <div class="filter-group" style="align-self: flex-end;">
                    <button id="applyFiltersBtn">Apply Filters</button>
                </div>
            </div>
        </div>
        
        <table class="orders-table">
            <h2>Pending Orders</h2>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <?= $pendingOrdersHTML ?>
            </tbody>
        </table>
        
        <div class="accepted-orders">
            <h2>Accepted Orders</h2>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="acceptedOrdersTable">
                    <?= $acceptedOrdersHTML ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?> 

</body>
</html>



<script>
    document.getElementById('applyFiltersBtn').addEventListener('click', () => {
        const status = document.getElementById('statusFilter').value.toLowerCase();
        const orderId = document.getElementById('orderIdFilter').value.toLowerCase();
        const customer = document.getElementById('customerFilter').value.toLowerCase();
        const dateFrom = document.getElementById('dateFromFilter').value;
        const dateTo = document.getElementById('dateToFilter').value;

        const rows = document.querySelectorAll('#ordersTableBody tr');
    
        rows.forEach(row => {
            const rowStatus = row.querySelector('td:nth-child(6) .status-badge').textContent.toLowerCase();
            const rowOrderId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const rowCustomer = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const rowDate = row.querySelector('td:nth-child(2)').textContent.trim();

            let dateMatch = true;
            if (dateFrom) {
                dateMatch = new Date(rowDate) >= new Date(dateFrom);
            }
            if (dateTo) {
                dateMatch = dateMatch && new Date(rowDate) <= new Date(dateTo);
            }

            const statusMatch = status === 'all' || rowStatus === status;
            const orderIdMatch = rowOrderId.includes(orderId);
            const customerMatch = rowCustomer.includes(customer);
    
            if (statusMatch && orderIdMatch && customerMatch && dateMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // handle refresh data button
    document.getElementById("refreshBtn").addEventListener("click", function() {
    fetch(window.location.href + "?fetchOrders=true")
        .then(response => response.text())
        .then(data => {
            document.getElementById("ordersTableBody").innerHTML = data;
        })
        .catch(error => console.error("Error fetching data:", error));
    });

    document.getElementById("refreshBtn").addEventListener("click", function() {
        location.reload();
    });

    // Handle accept order button
    function acceptOrder(orderId) {
        if (confirm("Are you sure you want to accept this order?")) {
            fetch('ProcessOrder.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `acceptOrder=true&order_id=${orderId}`
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                // Update status in the table row
                const row = document.getElementById("order-" + orderId);
                row.querySelector('.status-badge').textContent = 'Shipped';
                row.querySelector('.status-badge').classList.remove('status-pending');
                row.querySelector('.status-badge').classList.add('status-processing');
            })
            .catch(error => console.error("Error:", error));
        }
    }

    // Handle cancel order button
    function cancelOrder(orderId) {
        if (confirm("Are you sure you want to cancel this order?")) {
            fetch('ProcessOrder.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `cancelOrder=true&order_id=${orderId}`
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                // Remove the row from the table
                const row = document.getElementById("order-" + orderId);
                row.remove();
            })
            .catch(error => console.error("Error:", error));
        }
    }
</script>
    
    