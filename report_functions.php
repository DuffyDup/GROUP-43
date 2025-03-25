<?php
function getSalesData($db)
{
    $sql = "SELECT * FROM Purchased ORDER BY purchase_date DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTopSellingProducts($db)
{
    $sql = "SELECT P.name, COUNT(O.product_id) as sold_count 
            FROM Purchased O 
            JOIN Products P ON O.product_id = P.product_id 
            GROUP BY O.product_id 
            ORDER BY sold_count DESC LIMIT 5";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOrderStatistics($db)
{
    $stats = [];

    // Get total orders
    $sql = "SELECT COUNT(order_id) AS total_orders FROM Purchased";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['total_orders'] = $row['total_orders'];

    // Get pending orders
    $sql = "SELECT COUNT(order_id) AS pending_orders FROM Purchased WHERE order_status = 'Pending'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['pending_orders'] = $row['pending_orders'];

    // Get shipped orders
    $sql = "SELECT COUNT(order_id) AS shipped_orders FROM Purchased WHERE order_status = 'Shipped'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['shipped_orders'] = $row['shipped_orders'];

    // Get cancelled orders
    $sql = "SELECT COUNT(order_id) AS cancelled_orders FROM Purchased WHERE order_status = 'Cancelled'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['cancelled_orders'] = $row['cancelled_orders'];

    // Get revenue per month for the revenue chart
    $sql = "
        SELECT DATE_FORMAT(time_of_order, '%Y-%m') AS month, 
               SUM(quantity * (SELECT price FROM Products WHERE Products.product_id = Purchased.product_id)) AS revenue
        FROM Purchased
        GROUP BY month
        ORDER BY month ASC";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $revenue_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare separate arrays for dates and revenues
    $dates = [];
    $revenues = [];

    foreach ($revenue_data as $data) {
        $dates[] = $data['month'];
        $revenues[] = $data['revenue'];
    }

    $stats['dates'] = $dates;
    $stats['revenues'] = $revenues;

    return $stats;
}


?>