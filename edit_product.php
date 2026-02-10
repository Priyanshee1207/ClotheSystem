<?php
$conn = new mysqli("localhost", "root", "", "style_alley");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_GET['id'] ?? null;
if (!$product_id) {
    die("No product ID provided.");
}

$product = null;
$categories = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    $update_sql = "UPDATE products 
                   SET product_name='$product_name', product_price='$product_price', stock='$stock', category_id='$category_id' 
                   WHERE product_id='$product_id'";
    
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_data = file_get_contents($image_tmp);
        $image_data = $conn->real_escape_string($image_data);

        $update_sql = "UPDATE products 
                       SET product_name='$product_name', product_price='$product_price', stock='$stock', category_id='$category_id',
                           image_name='$image_name', image_data='$image_data'
                       WHERE product_id='$product_id'";
    }

    if ($conn->query($update_sql) === TRUE) {
        header("Location: product.php?updated=1");
        exit();
    } else {
        echo "Update failed: " . $conn->error;
    }
} else {
    $result = $conn->query("SELECT * FROM products WHERE product_id = '$product_id'");
    $product = $result->fetch_assoc();

    $catResult = $conn->query("SELECT category_id, category_name FROM categories");
    while ($cat = $catResult->fetch_assoc()) {
        $categories[] = $cat;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; background: #f3f4f6; padding: 40px; }
        .edit-form { background: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .edit-form input, .edit-form select { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        .edit-form button { padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .edit-form button:hover { background: #1e40af; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit Product</h2>

<form action="" method="post" enctype="multipart/form-data" class="edit-form">
    <input type="text" name="product_name" value="<?= $product['product_name'] ?>" required>
    <input type="number" step="0.01" name="product_price" value="<?= $product['product_price'] ?>" required>
    <input type="number" name="stock" value="<?= $product['stock'] ?>" required>

    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['category_id'] ?>" <?= $product['category_id'] == $cat['category_id'] ? 'selected' : '' ?>>
                <?= $cat['category_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Update Image (optional):</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Update Product</button>
</form>

</body>
</html>
