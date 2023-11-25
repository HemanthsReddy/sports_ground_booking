<?php
session_start();
include "db_connection.php";

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['gender'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mob_num = isset($_POST['mob_num']) ? $_POST['mob_num'] : null;  // Optional field
    $gender = $_POST['gender'];
    $user_id = $username;

    // Validate user inputs here if needed

    // Check if the username is already taken
    $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_username_result = mysqli_query($conn, $check_username_sql);

    if (mysqli_num_rows($check_username_result) > 0) {
        header("Location: signup.php?error=Username already exists");
        exit();
    }

    // Insert the new user into the database without hashing the password
    $insert_user_sql = "INSERT INTO users (fname, lname, user_id, username, passwd, mob_num, gender) VALUES ('$fname', '$lname', '$user_id', '$username', '$password', '$mob_num', '$gender')";
    $insert_user_result = mysqli_query($conn, $insert_user_sql);

    if ($insert_user_result) {
        // Create the user and grant the role using an administrative MySQL user
        $create_user_sql = "CREATE USER '$username'@'%' IDENTIFIED BY '$password'";
        $create_user_result = mysqli_query($conn, $create_user_sql);

        if (!$create_user_result) {
            // Handle error if user creation fails
            header("Location: signup.php?error=Failed to create user");
            exit();
        }

        // Grant the role to the new user
        $grant_role_sql = "GRANT user TO '$username'@'%'";
        $grant_role_result = mysqli_query($conn, $grant_role_sql);

        if (!$grant_role_result) {
            // Handle error if the role granting fails
            header("Location: signup.php?error=Failed to grant role to user");
            exit();
        }

        // Redirect to the login page or any other page as needed
        header("Location: index.php?success=User created successfully");
        exit();
    } else {
        // Handle error if user insertion fails
        header("Location: signup.php?error=User creation failed");
        exit();
    }
} else {
    header("Location: signup.php?error=All fields are required");
    exit();
}
?>
