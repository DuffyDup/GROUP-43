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
                    <th>Tracking #</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <tr>
                    <td>ORD-1001</td>
                    <td>2025-03-20</td>
                    <td>random person</td>
                    <td>items</td>
                    <td>£89.99</td>
                    <td><span class="status-badge status-pending">Pending</span></td>
                    <td>-</td>
                    <td class="actions">
                        <button class="btn-success" title="Accept Order" onclick="acceptOrder('ORD-1001')">Accept</button>
                        <button class="btn-danger" title="Cancel Order" onclick="cancelOrder('ORD-1001')">Cancel</button>
                    </td>
                </tr>
                <tr>
                    <td>ORD-1002</td>
                    <td>2025-03-18</td>
                    <td>random person</td>
                    <td>item</td>
                    <td>£45.50</td>
                    <td><span class="status-badge status-pending">Pending</span></td>
                    <td>-</td>
                    <td class="actions">
                        <button class="btn-success" title="Accept Order" onclick="acceptOrder('ORD-1002')">Accept</button>
                        <button class="btn-danger" title="Cancel Order" onclick="cancelOrder('ORD-1002')">Cancel</button>
                    </td>
                </tr>
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
                        <th>Tracking #</th>
                        <th>Change Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="acceptedOrdersTable">
                    <tr id="ORD-1001">
                        <td>ORD-1001</td>
                        <td>2025-03-20</td>
                        <td>random person</td>
                        <td>items</td>
                        <td>£89.99</td>
                        <td><span class="status-badge status-processing">Processing</span></td>
                        <td>-</td>
                        <td>
                            <select id="changeStatus-ORD-1001" class="status-dropdown" onchange="changeOrderStatus('ORD-1001')">
                                <option value="pending">Pending</option>
                                <option value="processing" selected>Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </td>
                        <td class="actions">
                            <button class="btn-success" title="Save Changes" onclick="saveChanges('ORD-1001')">Save Changes</button>
                            <button class="btn-danger" title="Cancel" onclick="cancelOrder('ORD-1001')">Cancel</button>
                        </td>
                    </tr>
                    <tr id="ORD-1002">
                        <td>ORD-1002</td>
                        <td>2025-03-18</td>
                        <td>random person</td>
                        <td>item</td>
                        <td>£45.50</td>
                        <td><span class="status-badge status-shipped">Shipped</span></td>
                        <td>TRK123456</td>
                        <td>
                            <select id="changeStatus-ORD-1002" class="status-dropdown" onchange="changeOrderStatus('ORD-1002')">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped" selected>Shipped</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </td>
                        <td class="actions">
                            <button class="btn-success" title="Save Changes" onclick="saveChanges('ORD-1002')">Save Changes</button>
                            <button class="btn-danger" title="Cancel" onclick="cancelOrder('ORD-1002')">Cancel</button>
                        </td>
                    </tr>
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
    </script>
    
    