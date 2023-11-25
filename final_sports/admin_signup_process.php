<?php
session_start();
include "db_connection.php";

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['password'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mob_num = isset($_POST['mob_num']) ? $_POST['mob_num'] : null;  // Optional field
    $user_id = $username;

    // Validate user inputs here if needed

    // Check if the username is already taken
    $check_admin_sql = "SELECT * FROM admins WHERE username = '$username'";
    $check_admin_result = mysqli_query($conn, $check_admin_sql);

    if (mysqli_num_rows($check_admin_result) > 0) {
        header("Location: admin_signup.php?error=Username already exists");
        exit();
    }

    // Insert the new admin into the database without hashing the password
    $insert_admin_sql = "INSERT INTO admins (fname, lname, admin_id, username, passwd, mob_num) VALUES ('$fname', '$lname', '$user_id', '$username', '$password', '$mob_num')";
    $insert_admin_result = mysqli_query($conn, $insert_admin_sql);

    if ($insert_admin_result) {
        // Create the admin and grant the role using an administrative MySQL user
        $create_admin_sql = "CREATE USER '$username'@'%' IDENTIFIED BY '$password'";
        $create_admin_result = mysqli_query($conn, $create_admin_sql);

        if (!$create_admin_result) {
            // Handle error if admin creation fails
            header("Location: admin_signup_process.php?error=Failed to create admin");
            exit();
        }

        // Grant the role to the new admin
        $grant_role_sql = "GRANT admin TO '$username'@'%'";
        $grant_role_result = mysqli_query($conn, $grant_role_sql);

        if (!$grant_role_result) {
            // Handle error if the role granting fails
            header("Location: admin_signup_process.php?error=Failed to grant role to admin");
            exit();
        }

        // Redirect to the login page or any other page as needed
        header("Location: admin_home.php?success=Admin created successfully");
        exit();
    } else {
        // Handle error if admin insertion fails
        header("Location: admin_signup_process.php?error=Admin creation failed");
        exit();
    }
} else {
    header("Location: admin_signup_process.php?error=All fields are required");
    exit();
}
?>
