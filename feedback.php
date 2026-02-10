<?php 
session_start();
$conn = new mysqli("localhost", "root", "", "style_alley");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM feedback ORDER BY feedback_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table th, .table td {
            padding: 14px 16px;
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

        .message-col {
            max-width: 400px;
            word-wrap: break-word;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                width: 100%;
            }

            .table, th, td {
                font-size: 13px;
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
    <h2>Customer Feedbacks</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Feedback ID</th>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th class="message-col">Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['feedback_id'] ?></td>
                    <td><?= $row['customer_id'] ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td><?= $row['feedback_date'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
