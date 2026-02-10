<?php
include('db_connect.php');

$customer_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM customers"))['count'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM products"))['count'];
$category_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM categories"))['count'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders"))['count'];
$payment_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM payments"))['count'];
$feedback_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM feedback"))['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Style Alley</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #e5ecef;
            display: flex;
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
            padding: 40px 20px;
            width: calc(100% - 220px);
        }

        .header {
            background-color: #222;
            color: #fff;
            padding: 25px;
            text-align: center;
            font-size: 28px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .card {
            background: #ffffff;
            padding: 30px 20px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
            position: relative;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card h2 {
            font-size: 36px;
            margin: 0;
        }

        .card p {
            font-size: 16px;
            color: #666;
            margin-top: 12px;
            font-weight: 500;
        }

        .card:nth-child(1) h2 { color: rgb(255, 0, 191); }
        .card:nth-child(2) h2 { color: #28a745; }
        .card:nth-child(3) h2 { color: #ffc107; }
        .card:nth-child(4) h2 { color: rgb(208, 8, 28); }
        .card:nth-child(5) h2 { color: #17a2b8; }
        .card:nth-child(6) h2 { color: rgb(66, 17, 156); }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 5px;
            width: 100%;
            background: #0dcaf0;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
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

            .header {
                font-size: 22px;
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
    <div class="header">
        Admin Dashboard - Style Alley
    </div>

    <div class="dashboard">
        <div class="card">
            <h2><?= $customer_count ?></h2>
            <p>Total Customers</p>
        </div>
        <div class="card">
            <h2><?= $product_count ?></h2>
            <p>Total Products</p>
        </div>
        <div class="card">
            <h2><?= $category_count ?></h2>
            <p>Total Categories</p>
        </div>
        <div class="card">
            <h2><?= $order_count ?></h2>
            <p>Total Orders</p>
        </div>
        <div class="card">
            <h2><?= $payment_count ?></h2>
            <p>Payments Received</p>
        </div>
        <div class="card">
            <h2><?= $feedback_count ?></h2>
            <p>Feedback Received</p>
        </div>
    </div>
</div>

</body>
</html>
