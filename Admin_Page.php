<?php
    require_once("connectdb.php");
   $errorMessage = "";


    $stmt = $db->query("SELECT uid FROM users");
    $userIDs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if(isset($_POST['submit'])) {
        $title = $_POST['title'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $description = $_POST['description'];
        $phase = $_POST['phase'];
        $userId = $_POST['user_id'];
        
        if (empty($title)) {
            $errorMessage .= "Title is required!<br>";
        }
        if (empty($startDate)) {
            $errorMessage .= "Start Date is required!<br>";
        }
        if (empty($endDate)) {
            $errorMessage .= "End Date is required!<br>";
        }
        if (empty($description)) {
            $errorMessage .= "Description is required!<br>";
        }
        if (empty($phase)) {
            $errorMessage .= "Phase is required!<br>";
        }
        if (empty($userId)) {
            $errorMessage .= "User ID is required!<br>";
        }
        if (!in_array($userId, $userIDs)) {
            $errorMessage .= "Invalid User ID!<br>";
        }
        if (!empty($startDate) && !empty($endDate)) {
            $startDateTimestamp = strtotime($startDate);
            $endDateTimestamp = strtotime($endDate);
            
            if ($endDateTimestamp < $startDateTimestamp) {
                $errorMessage .= "End Date cannot be before Start Date!<br>";
            }
        }
        if (!empty($errorMessage)) {
            echo "<div style='color: red; text-align: center; margin-bottom: 20px;'>$errorMessage</div>";
        } else {
            $stmt = $db->prepare("INSERT INTO projects (title, start_date, end_date, description, phase, uid) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $startDate, $endDate, $description, $phase, $userId]);
            header("Location: projects.php"); 
            exit();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HomePage</title>
    <link rel="icon" type="image/png" href="Tech_Nova.png">
    <link rel="icon" type="image/x-icon" href="Tech_Nova.png">
    
</head>
<body>
<section id="projects">
    <h2>Add New Products</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="title">:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="start_date">Start Date:</label><br>
        <input type="date" id="start_date" name="start_date"><br>
        <label for="end_date">End Date:</label><br>
        <input type="date" id="end_date" name="end_date"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4"></textarea><br>
        </select><br>
        <input type="submit" name="submit" value="Add Project"><br> 
    </form>
</section>
</body>
</html>