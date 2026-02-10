<?php  
$conn = new mysqli("localhost", "root", "", "style_alley");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_data = file_get_contents($image_tmp);
    $image_data = $conn->real_escape_string($image_data);

    $sql = "INSERT INTO products (product_name, product_price, stock, category_id, image_name, image_data)
            VALUES ('$product_name', '$product_price', '$stock', '$category_id', '$image_name', '$image_data')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Product added successfully!";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}

$categories = [];
$catResult = $conn->query("SELECT category_id, category_name FROM categories");
while ($cat = $catResult->fetch_assoc()) {
    $categories[] = $cat;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f3f4f6;
    }

    .sidebar {
        width: 220px;
        height: 100vh;
        background-color: #343a40;
        padding-top: 20px;
        position: fixed;
        top: 0;
        left: 0;
    }

    .sidebar h2 {
        color: #f8f9fa;
        text-align: center;
        padding-bottom: 20px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        padding: 15px;
        display: block;
        transition: background-color 0.2s ease-in-out;
        font-weight: bold;
    }

    .sidebar a:hover {
        background-color: #495057;
        border-left: 4px solid #ffc107;
    }

    .main {
        margin-left: 240px;
        padding: 40px;
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
        width: 85%;
    }

    .logout:hover {
        background: red;
        color: white;
    }

    .form-horizontal {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 40px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .form-horizontal .form-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        justify-content: flex-start;
    }

    .form-horizontal input,
    .form-horizontal select {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        flex: 1 1 auto;
        min-width: 120px;
    }

    .form-horizontal button {
        background-color: #2563eb;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        white-space: nowrap;
    }

    .form-horizontal button:hover {
        background-color: #1e40af;
    }

    .success-message,
    .error-message {
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .success-message {
        background-color: #d1fae5;
        color: #065f46;
    }

    .error-message {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* ✅ UPDATED TABLE STYLES */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #f3f4f6;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    th {
        background-color: #3a4047;
        color: #f0f0f0;
        padding: 14px 16px;
        text-align: left;
        font-weight: bold;
        border-right: 1px solid #5a5f66;
        font-size: 15px;
    }

    td {
        padding: 14px 16px;
        border-bottom: 1px solid #e5e7eb;
        background-color: #ffffff;
        color: #374151;
        font-size: 18px;
    }

    tr:hover td {
        background-color: #f9fafb;
    }

    td:last-child, th:last-child {
        border-right: none;
    }

    img.product-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 6px;
    }

    .action-btn {
        padding: 10px 40px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
    }

    .delete-btn {
        background-color:rgb(213, 0, 0);
        color: white;
    }

    .delete-btn:hover {
        background-color:rgb(142, 0, 0);
    }

    .edit-btn {
        background-color:rgb(255, 102, 0);
        color: white;
    }

    .edit-btn:hover {
        background-color: #d97706;
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
    <h1>ADD PRODUCTS</h1>

    <?php if ($successMessage): ?>
        <div class="success-message"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Horizontal Add Product Form -->
    <form action="product.php" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="number" step="0.01" name="product_price" placeholder="Price" required>
            <input type="number" name="stock" placeholder="Stock" required>
            <select name="category_id" required>
                <option value="">Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>">
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Add Product</button>
        </div>
    </form>

    <!-- Product Table -->
    <h2>MANAGE All PRODUCTS</h2>
    <?php
    $sql = "SELECT p.product_id, p.product_name, p.product_price, p.stock, c.category_name, p.image_data
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            ORDER BY p.uploaded_at DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['image_data']); ?>" class="product-image"></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>₹<?php echo number_format($row['product_price'], 2); ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <form action="delete_product.php" method="POST" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                            <button type="submit" class="action-btn delete-btn">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="action-btn edit-btn">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

</body>
</html>
