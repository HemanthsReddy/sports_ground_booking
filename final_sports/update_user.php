<?php
session_start();
include_once 'db_connection.php';

if (count($_POST) > 0) {
    $userId = $_POST['user_id'];
    $newUsername = $_POST['new_username'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $mobileNumber = $_POST['mob_num'];

    // Check if the new username or user_id already exists
    $checkUserQuery = "SELECT COUNT(*) as count FROM users WHERE (username='" . $newUsername . "' OR user_id='" . $newUsername . "') AND user_id != '" . $userId . "'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);
    $userCount = mysqli_fetch_assoc($checkUserResult)['count'];

    if ($userCount == 0) {
        // Update the user details in the database
        $updateQuery = "UPDATE users SET user_id=?, fname=?, lname=?, username=?,  mob_num=? WHERE user_id=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssss", $newUsername, $firstName, $lastName, $newUsername, $mobileNumber, $userId);

        if ($stmt->execute()) {
            $message = "Record Modified Successfully";
            header("Location: index.php");
            exit();
        } else {
            $message = "Error updating user details: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Username or User ID already exists. Please choose a different username or User ID.";
    }
}

// Fetch user information for display
$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id ='" . $_GET['user_id'] . "'");
$row = mysqli_fetch_array($result);
?>

<html>

<head>
    <title>Update User Data</title>
    <link rel="stylesheet" type="text/css" href="update_user_style.css">
</head>

<body>
    <div class="container">
        <form name="frmUser" method="post" action="">
            <div><?php if (isset($message)) {
                        echo $message;
                    } ?>
            </div>

            User ID: <br>
            <input type="text" name="user_id" class="txtField" value="<?php echo $row['user_id']; ?>" readonly>
            <br>
            New Username/User ID:<br>
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
            <input type="submit" name="submit" value="Update User Info" class="button">
        </form>
    </div>
</body>

</html>
