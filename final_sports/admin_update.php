<?php
session_start();
include_once 'db_connection.php';

if (count($_POST) > 0) {
    $userId = $_POST['admin_id'];
    $newUsername = $_POST['new_username'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $mobileNumber = $_POST['mob_num'];

    // Check if the new username or admin_id already exists
    $checkUserQuery = "SELECT COUNT(*) as count FROM admins WHERE (username='" . $newUsername . "' OR admin_id='" . $newUsername . "') AND admin_id != '" . $userId . "'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);
    $userCount = mysqli_fetch_assoc($checkUserResult)['count'];

    if ($userCount == 0) {
        // Update the foreign key references in the 'grounds' table
        $updateGroundsQuery = "UPDATE grounds SET g_owner=? WHERE g_owner=?";
        $stmtGrounds = $conn->prepare($updateGroundsQuery);
        $stmtGrounds->bind_param("ss", $newUsername, $userId);

        // Execute the 'grounds' update query
        if ($stmtGrounds->execute()) {
            // Update the user details in the database
            $updateQuery = "UPDATE admins SET admin_id=?, fname=?, lname=?, username=?,  mob_num=? WHERE admin_id=?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssssss", $newUsername, $firstName, $lastName, $newUsername,  $mobileNumber, $userId);

            if ($stmt->execute()) {
                $message = "Record Modified Successfully";
                header("Location: admin_login.php");
                exit();
            } else {
                $message = "Error updating user details: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Error updating user details in grounds table: " . $stmtGrounds->error;
        }

        $stmtGrounds->close();
    } else {
        $message = "Username or Admin ID already exists. Please choose a different username or User ID.";
    }
}

// Fetch user information for display
$result = mysqli_query($conn, "SELECT * FROM admins WHERE admin_id ='" . $_GET['admin_id'] . "'");
$row = mysqli_fetch_array($result);
?>

<html>

<head>
    <title>Update Admin Data</title>
    <link rel="stylesheet" type="text/css" href="update_user_style.css">
</head>

<body>
    <div class="container">
        <form name="frmUser" method="post" action="">
            <div><?php if (isset($message)) {
                        echo $message;
                    } ?>
            </div>

            Admin ID: <br>
            <input type="text" name="admin_id" class="txtField" value="<?php echo $row['admin_id']; ?>" readonly>
            <br>
            New Username/Admin ID:<br>
            <input type="text" name="new_username" class="txtField" value="<?php echo $row['username']; ?>">
            <br>
            First Name: <br>
            <input type="text" name="first_name" class="txtField" value="<?php echo $row['fname']; ?>">
            <br>
            Last Name :<br>
            <input type="text" name="last_name" class="txtField" value="<?php echo $row['lname']; ?>">
            <br>

            Mobile Number:<br>
            <input type="text" name="mob_num" class="txtField" value="<?php echo $row['mob_num']; ?>">
            <br>
            <input type="submit" name="submit" value="Update Admin Info" class="button">
        </form>
    </div>
</body>

</html>
