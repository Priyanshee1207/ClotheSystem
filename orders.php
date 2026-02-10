<?php  
$conn = new mysqli("localhost", "root", "", "style_alley");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders
$order_sql = "SELECT * FROM orders ORDER BY order_date DESC";
$order_result = $conn->query($order_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
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
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }

        .order-box {
            background: #fff;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .order-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .order-info {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 16px;
        }

        .items-table th {
            background: #343a40;
            color: white;
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 15px;
            font-size: 20px;
            color: #444;
        }

        .status-label {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 5px;
            background: #ccc;
            font-size: 14px;
            font-weight: 600;
            color: #000;
            margin-top: 10px;
        }

        .Pending { background: #ffc107; }
        .Processing { background: #17a2b8; color: #fff; }
        .Shipped { background: #28a745; color: #fff; }
        .Cancelled { background: #dc3545; color: #fff; }

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
        }
    </style>
</head>
<body>

<!-- ✅ SIDEBAR -->
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

<!-- ✅ MAIN CONTENT -->
<div class="main">
    <h2>All Orders</h2>

    <?php if ($order_result->num_rows > 0): ?>
        <?php while ($order = $order_result->fetch_assoc()): ?>
            <div class="order-box">
                <div class="order-header">
                    Order #<?= $order['order_id']; ?> — <?= $order['order_date']; ?>
                </div>
                <div class="order-info">
                    <strong>Name:</strong> <?= htmlspecialchars($order['customer_name']); ?><br>
                    <strong>Phone:</strong> <?= htmlspecialchars($order['customer_phone']); ?><br>
                    <strong>Address:</strong> <?= htmlspecialchars($order['customer_address']); ?><br>
                    <span class="status-label <?= $order['order_status'] ?>"><?= $order['order_status'] ?></span>
                </div>

                <!-- Fetch order items -->
                <?php
                    $order_id = $order['order_id'];
                    $item_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
                    $item_result = $conn->query($item_sql);
                ?>
                <?php if ($item_result->num_rows > 0): ?>
                    <table class="items-table">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                        <?php while ($item = $item_result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item['image_data'])): ?>
                                        <img src="data:image/jpeg;base64,<?= base64_encode($item['image_data']) ?>" class="product-img">
                                    <?php else: ?>
                                        <span>No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($item['product_name']); ?></td>
                                <td><?= htmlspecialchars($item['product_size']); ?></td>
                                <td>₹<?= number_format($item['product_price'], 2); ?></td>
                                <td><?= $item['quantity']; ?></td>
                                <td>₹<?= number_format($item['subtotal'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No items found for this order.</p>
                <?php endif; ?>

                <div class="total">
                    Total Amount: ₹<?= number_format($order['total_amount'], 2); ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
