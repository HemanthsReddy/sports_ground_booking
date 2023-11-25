<?php
session_start();
include "db_connection.php";



if (isset($_POST['gname']) && isset($_POST['loc']) && isset($_POST['price']) && isset($_POST['sid']) && isset($_POST['gowner'])) {
    $gname = $_POST['gname'];
    $gid = $_POST['gname'] ;
    $loc = $_POST['loc'];
    $price = $_POST['price'];
    $sid = $_POST['sid'];
    $image = $_FILES['image']['name'];
    
    $g_owner =$_POST['gowner'];
    $target = "images/".basename($image);

    // Validate user inputs here if needed

    // Check if the username is already taken
    $check_admin_sql = "SELECT * FROM grounds WHERE ground_name = '$gname'";
    $check_admin_result = mysqli_query($conn, $check_admin_sql);

    if (mysqli_num_rows($check_admin_result) > 0) {
        header("Location: host_ground.php?error=Username already exists");
        exit();
    }

    // Insert the new user into the database without hashing the password
    $insert_admin_sql = "INSERT INTO grounds (ground_id, location, ground_name, price, g_owner, sportid ,image) VALUES ('$gid', '$loc', '$gname', '$price', '$g_owner', '$sid', '$image')";
    $insert_admin_result = mysqli_query($conn, $insert_admin_sql);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    }else{
        $msg = "Failed to upload image";
    }
    header("Location: admin_home.php?error=All fields are required");
    exit();

} else {
    header("Location: host_ground.php?error=All fields are required");
    exit();
}

