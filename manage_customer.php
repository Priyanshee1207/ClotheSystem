<?php 
include('db_connect.php');
session_start();

// Initialize admin name to avoid undefined variable error
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : "Admin";

// Delete customer securely
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Sanitize input
    $conn->query("DELETE FROM customers WHERE customer_id=$id");
    header("Location: manage_customer.php");
    exit();
}

// Fetch customers
$result = $conn->query("SELECT * FROM customers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        background-color: #f4f6f9;
    }

    .sidebar {
        width: 220px;
        height: 100vh;
        background-color: #2e3338;
        padding-top: 20px;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sidebar h2 {
        color: white;
        margin-bottom: 30px;
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        width: 100%;
        text-align: left;
        font-weight: 600;
        transition: background-color 0.2s ease-in-out;
    }

    .sidebar a:hover {
        background-color: #495057;
        border-left: 4px solid #ffc107;
        padding-left: 16px;
    }

    .logout {
        background: black;
        color: white;
        padding: 10px;
        text-align: center;
        margin: 20px auto;
        text-decoration: none;
        border-radius: 5px;
        display: block;
        width: 80%;
    }

    .logout:hover {
        background: red;
        color: white;
    }

    .main-content {
        margin-left: 220px;
        padding: 40px;
        width: calc(100% - 220px);
        background-color: #f4f6f9;
    }

    h2 {
        margin-bottom: 30px;
        color: #333;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #dee2e6;
    }

    .table thead th {
        background-color: #343a40;
        color: white;
        font-size: 14px;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-delete:hover {
        background-color: #b02a37;
    }

    @media screen and (max-width: 768px) {
        .sidebar {
            position: static;
            width: 100%;
            height: auto;
        }

        .main-content {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>STYLE_ALLEY</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_customer.php">Customers</a>
    <a href="categories.php">Categories</a>
    <a href="product.php">Products</a>
    <a href="orders.php">Orders</a>
    <a href="feedback.php">Feedback</a>
    <a href="payment.php">Payments</a>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="main-content">
    <h2>Customer Management</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th> <!-- Displayed correctly now -->
                <th>Address</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= isset($row['customer_id']) ? $row['customer_id'] : 'N/A' ?></td>
                <td><?= isset($row['customer_name']) ? htmlspecialchars($row['customer_name']) : 'N/A' ?></td>
                <td><?= isset($row['email']) ? htmlspecialchars($row['email']) : 'N/A' ?></td>
                <td><?= isset($row['phone_number']) ? htmlspecialchars($row['phone_number']) : 'N/A' ?></td>
                <td><?= isset($row['address']) ? htmlspecialchars($row['address']) : 'N/A' ?></td>
                <td>
                    <a href="manage_customer.php?delete=<?= isset($row['customer_id']) ? $row['customer_id'] : '#' ?>" 
                        class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
