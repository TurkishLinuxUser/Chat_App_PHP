<?php
session_start();


if (!isset($_SESSION['admin_username'])) {
    header("Location: loginadmin.php");
    exit();
}

$hostname = "localhost";
$username = "debian-sys-maint";
$password = "";
$dbname = "chatapp";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $newPassword = $conn->real_escape_string($_POST['newPassword']);

    $hashedPassword = md5($newPassword);

    $sql = "UPDATE users SET password='$hashedPassword' WHERE user_id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $conn->error;
    }
}

$conn->close();
?>
