<?php
$conn = new mysqli("localhost", "root", "", "style_alley");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM products WHERE product_id = $product_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: product.php?deleted=1");
        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}
?>
