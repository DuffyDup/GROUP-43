<?php 
session_start();  
require_once 'connectdb.php';   

if (!isset($_SESSION['email'])) {     
    echo "Please log in to view your previous orders.";     
    exit; 
}  

$email = $_SESSION['email'];    

$query = "     
    SELECT          
        o.order_id,         
        SUM(p.quantity * pr.price) AS total_price,     
        o.time_of_order   
    FROM Orders o
    JOIN Purchased p ON o.order_id = p.order_id
    JOIN Products pr ON p.product_id = pr.product_id     
    WHERE o.email = :email     
    GROUP BY o.order_id, o.time_of_order
    ORDER BY o.time_of_order DESC
";  

try {        
    $stmt = $db->prepare($query);     
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);     
    $stmt->execute();       
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch (PDOException $e) {     
    die("Error fetching orders: " . $e->getMessage()); 
} 
?>  

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Your Previous Orders</title>     
    <link rel="stylesheet" href="main.css"> 
    <link rel="stylesheet" href="Previous_Order.css"> 
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
</head> 
<body>     
    <?php include 'Navbar.php'; ?>      

    <div class="previous-orders">         
        <h2>Your Previous Orders</h2>         
        <h3> Click on the Order ID to view order details</h3>          
        <?php if (empty($orders)): ?>             
            <p>You have no previous orders.</p>         
        <?php else: ?>             
            <table border="1">                 
                <tr>                     
                    <th>Order ID</th>                                  
                    <th>Total Price</th>             
                    <th>Time of order</th>    
                </tr>                 
                <?php foreach ($orders as $order): ?>                     
                    <tr>                            
                        <td>
                            <a href="order_details.php?order_id=<?php echo urlencode($order['order_id']); ?>">
                                <?php echo htmlspecialchars($order['order_id']); ?>
                            </a>
                        </td>                                               
                        <td>£<?php echo number_format($order['total_price'], 2); ?></td>    
                        <td><?php echo htmlspecialchars($order['time_of_order']); ?></td>                 
                    </tr>                 
                <?php endforeach; ?>             
            </table>         
        <?php endif; ?>     
    </div>     

    <?php include 'footer.php'; ?> 
</body> 
</html>
