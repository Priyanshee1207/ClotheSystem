<?php
session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .logout-container {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .logout-container h2 {
            color: #dc3545;
        }
        .btn-login {
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="logout-container">
    <h2>You have been logged out</h2>
    <p>Thank you for using the admin dashboard. Click below to log in again.</p>
    <a href="index.php" class="btn-login">Go to Login</a>
</div>

</body>
</html>
