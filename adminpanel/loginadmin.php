<?php
session_start();


$hostname = "localhost";
$username = "debian-sys-maint";
$password = "";
$dbname = "chatapp";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];

    $sql = "SELECT * FROM adminusers WHERE username='$admin_username' AND password='$admin_password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $_SESSION['admin_username'] = $admin_username;
        header("Location: adminpanel.php");
        exit();
    } else {
        $login_error = "Invalid username or password.";
    }
}

if (isset($_SESSION['admin_username'])) {
    header("Location: adminpanel.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .login-box {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
        }

        .login-box input[type="text"],
        .login-box input[type="password"],
        .login-box button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-box button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="login-container">
        <h1>Admin Login</h1>
        <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="admin_login">Login</button>
        </form>
    </div>
</body>
</html>
