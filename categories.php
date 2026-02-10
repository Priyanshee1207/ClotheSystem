<?php  
include("db_connect.php");
session_start();

// Check if admin_name is set in session
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : "Admin";

// Add Category
if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $message = "Category added successfully!";
        } else {
            $error = "Error adding category.";
        }
    } else {
        $error = "Category name cannot be empty.";
    }
}

// Delete Category
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
    $stmt->bind_param("s", $category_id);
    if ($stmt->execute()) {
        $message = "Category deleted!";
    } else {
        $error = "Error deleting category.";
    }
}

// Fetch Categories
$result = $conn->query("SELECT * FROM categories ORDER BY category_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Categories</title>
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

        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-danger:hover {
            background-color: #b02a37;
        }

        .input-group input {
            border-radius: 0.375rem 0 0 0.375rem;
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
    <h2>Manage Categories</h2>

    <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="post" class="mb-4">
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['category_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td>
                            <a href="categories.php?delete=<?php echo $row['category_id']; ?>"
                               onclick="return confirm('Are you sure you want to delete this category?')"
                               class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
