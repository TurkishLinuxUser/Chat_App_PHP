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

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles_dark.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 85%;
            margin-top: 20px;
        }

        .table-wrapper {
            max-height: 70vh; 
            overflow-y: auto; 
            margin-top: 20px;
            border: 1px solid #555; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #555;
        }

        .deleteUserBtn, .changePasswordBtn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .deleteUserBtn {
            background-color: #d9534f;
            color: #fff;
        }

        .changePasswordBtn {
            background-color: #5bc0de;
            color: #fff;
        }

        .changePasswordBtn:hover, .deleteUserBtn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["fname"] . "</td>";
                            echo "<td>" . $row["lname"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . reverse_md5($row["password"]) . "</td>";
                            echo "<td><a href='../p/images/" . $row["img"] . "'>" . $row["img"] . "</a></td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>";
                            echo "<button class='deleteUserBtn' data-id='" . $row["user_id"] . "'><i class='fas fa-trash'></i> Delete User</button>";
                            echo "<button class='changePasswordBtn' data-id='" . $row["user_id"] . "'><i class='fas fa-key'></i> Change Password</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No users found</td></tr>";
                    }

                    function reverse_md5($md5_hash) {
                        return $md5_hash;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".changePasswordBtn").click(function() {
                var userId = $(this).data("id");
                var newPassword = prompt("Enter new password for user with ID " + userId + ":");

                if (newPassword !== null && newPassword !== "") {
                    $.ajax({
                        url: "change_password.php",
                        type: "POST",
                        data: { user_id: userId, newPassword: newPassword },
                        success: function(response) {
                            alert(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $(".deleteUserBtn").click(function() {
                var userId = $(this).data("id");
                var confirmDelete = confirm("Are you sure you want to delete user with ID " + userId + "?");
                if (confirmDelete) {
                    $.ajax({
                        url: "deleteuser.php",
                        type: "POST",
                        data: { userId: userId },
                        success: function(response) {
                            alert(response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
