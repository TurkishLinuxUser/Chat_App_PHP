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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
    $userId = $conn->real_escape_string($_POST['userId']);

    $sql = "DELETE FROM users WHERE user_id='$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

$conn->close();
?>
