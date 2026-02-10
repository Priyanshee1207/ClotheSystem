<?php 
$conn = new mysqli("localhost", "root", "", "style_alley");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$payments = $conn->query("SELECT * FROM payments ORDER BY payment_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Records</title>
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

        .main {
            margin-left: 220px;
            padding: 40px;
            width: calc(100% - 220px);
            background-color: #f4f6f9;
        }

        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 16px 20px;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #343a40;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0f3ff;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9em;
            display: inline-block;
        }

        .Success {
            background-color: #d4edda;
            color: #155724;
        }

        .Failed {
            background-color: #f8d7da;
            color: #721c24;
        }

        .Pending {
            background-color: #fff3cd;
            color: #856404;
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

            .main {
                margin-left: 0;
                padding: 20px;
                width: 100%;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
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

<div class="main">
    <h2>Payment Records</h2>

    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Razorpay Payment ID</th>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Amount (₹)</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($payments->num_rows > 0): ?>
            <?php while($row = $payments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['payment_id'] ?></td>
                    <td><?= htmlspecialchars($row['razorpay_payment_id']) ?></td>
                    <td><?= $row['order_id'] ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= number_format($row['amount'], 2) ?></td>
                    <td><span class="status <?= $row['payment_status'] ?>"><?= $row['payment_status'] ?></span></td>
                    <td><?= date("d M Y, h:i A", strtotime($row['payment_date'])) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No payments found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
