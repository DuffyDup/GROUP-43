<?php
require 'connectdb.php'; // Ensure this includes the $db PDO connection

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=customer_orders.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start output buffer
$output = fopen("php://output", "w");

// Add column headers
fputcsv($output, ['Order ID', 'Customer Email', 'Product Name', 'Quantity', 'Total Price', 'Purchase Date'], "\t");

try {
    // Query to fetch customer orders with product details, now using Orders table for email
    $sql = "SELECT o.order_id, o.email, pr.name AS product_name, p.quantity, p.total_price, p.purchase_date 
            FROM purchased p
            JOIN orders o ON p.order_id = o.order_id  -- Join Purchased with Orders to get the email
            JOIN products pr ON p.product_id = pr.product_id
            ORDER BY p.purchase_date DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output each row to the file
    foreach ($orders as $row) {
        fputcsv($output, $row, "\t");
    }

} catch (PDOException $ex) {
    echo "Error exporting data: " . $ex->getMessage();
}

fclose($output);
exit;
?>
