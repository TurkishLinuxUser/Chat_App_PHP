<?php 
session_start();
include_once "p/config.php";


if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}


$unique_id = $_SESSION['unique_id'];
$password = $_SESSION['password'];
$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '$unique_id' AND password = '$password'");
if (mysqli_num_rows($sql) == 0) {

    session_unset();
    session_destroy();
    header("location: login.php");
    exit();
}

$row = mysqli_fetch_assoc($sql);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<?php include_once "header.php"; ?>
<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <img src="p/images/<?php echo $row['img']; ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
                        <p><?php echo $row['status']; ?></p>
                    </div>
                </div>
                <a href="p/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
        
            </div>
        </section>
    </div>

    <script src="scr/users.js"></script>

</body>
</html>
