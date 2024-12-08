<?php
session_start();
require_once 'connectdb.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['email']) || $_SESSION['type'] !== 'admin') {
    header('Location: Login_Page.php');
    exit();
}

// Fetch customers
try {
    $stmt = $db->query("SELECT email, full_name, phone_number FROM Users WHERE type='customer'");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching customers: " . $e->getMessage();
    exit();
}

// Fetch admins
try {
    $stmt = $db->query("SELECT email, full_name, phone_number FROM Users WHERE type='admin'");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching admins: " . $e->getMessage();
    exit();
}

// Handle updates and deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $password = isset($_POST['password']) && !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if (isset($_POST['update_customer']) || isset($_POST['update_admin'])) {
        try {
            $updateQuery = "UPDATE Users SET full_name = :full_name, phone_number = :phone_number";
            $params = [
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'email' => $email,
            ];

            if ($password) {
                $updateQuery .= ", password = :password";
                $params['password'] = $password;
            }

            $updateQuery .= " WHERE email = :email";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->execute($params);

            echo "<script>alert('Details updated successfully.');</script>";
            header("Refresh:0");
        } catch (PDOException $e) {
            echo "Error updating details: " . $e->getMessage();
        }
    }

    if (isset($_POST['delete_customer']) || isset($_POST['delete_admin'])) {
        try {
            $deleteStmt = $db->prepare("DELETE FROM Users WHERE email = :email");
            $deleteStmt->execute(['email' => $email]);
            echo "<script>alert('User deleted successfully.');</script>";
            header("Refresh:0");
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <!-- Navigation -->
    <?php include 'Navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Customers Table -->
        <h2>Manage Customers</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>New Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <form method="POST">
                            <td><?= htmlspecialchars($customer['email']) ?></td>
                            <td><input type="text" name="full_name" value="<?= htmlspecialchars($customer['full_name']) ?>" required></td>
                            <td><input type="text" name="phone_number" value="<?= htmlspecialchars($customer['phone_number']) ?>" required></td>
                            <td><input type="password" name="password" placeholder="New Password"></td>
                            <td>
                                <button type="submit" name="update_customer" class="btn update-btn">Update</button>
                                <button type="submit" name="delete_customer" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</button>
                                <input type="hidden" name="email" value="<?= htmlspecialchars($customer['email']) ?>">
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Admins Table -->
        <h2>Manage Admins</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>New Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <form method="POST">
                            <td><?= htmlspecialchars($admin['email']) ?></td>
                            <td><input type="text" name="full_name" value="<?= htmlspecialchars($admin['full_name']) ?>" required></td>
                            <td><input type="text" name="phone_number" value="<?= htmlspecialchars($admin['phone_number']) ?>" required></td>
                            <td><input type="password" name="password" placeholder="New Password"></td>
                            <td>
                                <button type="submit" name="update_admin" class="btn update-btn">Update</button>
                                <button type="submit" name="delete_admin" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</button>
                                <input type="hidden" name="email" value="<?= htmlspecialchars($admin['email']) ?>">
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
