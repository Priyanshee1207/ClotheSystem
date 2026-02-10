<?php
session_start();

// Hardcoded admin credentials
$admin_username = "style_alley";
$admin_password = "s_t_123"; // Change this to a secure password

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Check credentials
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION["admin"] = $username; // Store session
        header("Location: admin_dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        $error_message = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: silver;
            padding: 40px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
            width: 300px;
        }
        h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            width: 100px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: white;
            color: #007BFF;
            border: 2px solid #007BFF;
            transition: 0.3s ease-in-out;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error_message)) echo "<p class='error'>$error_message</p>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
