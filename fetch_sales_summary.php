<?php
require 'connectdb.php'; // Ensure this includes the $db PDO connection

try {
    // Get total revenue
    $sql = "SELECT SUM(total_price) AS total_revenue FROM purchased";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

    // Get total number of orders
    $sql = "SELECT COUNT(order_id) AS total_orders FROM purchased";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'] ?? 0;

    // Get top-selling product
    $sql = "SELECT p.name AS product_name, SUM(pur.quantity) AS total_sold 
            FROM purchased pur
            JOIN products p ON pur.product_id = p.product_id
            GROUP BY pur.product_id
            ORDER BY total_sold DESC
            LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $top_product = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['product_name' => 'N/A', 'total_sold' => 0];

    // Display sales summary
    echo "<p><b>Total Revenue:</b> £" . number_format($revenue, 2) . "</p>";
    echo "<p><b>Total Orders:</b> $total_orders</p>";
    echo "<p><b>Top-Selling Product:</b> {$top_product['product_name']} ({$top_product['total_sold']} sold)</p>";

} catch (PDOException $ex) {
    echo "<p>Error fetching data: " . $ex->getMessage() . "</p>";
}
?>