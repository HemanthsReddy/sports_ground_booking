<?php
session_start();
include "db_connection.php";

if(isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }
}


$uname = validate($_POST['uname']);
$pass = validate($_POST['password']);

if(empty($uname)) {
    header( "Location: admin_login.php?error=User Name is required ");
    exit();
}

if(empty($pass)) {
    header( "Location: admin_login.php?error=Password is required ");
    exit();
}



$sql2 = "SELECT * FROM admins WHERE username = '$uname' AND passwd= '$pass'";
$result2 = mysqli_query($conn, $sql2);





if(mysqli_num_rows($result2)=== 1){
    $row = mysqli_fetch_assoc($result2);
    if($row['username'] === $uname && $row['passwd'] === $pass){
        echo "Loggin in";
        $_SESSION['username'] = $row['username'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['mob_num'] = $row['mob_num'];
        header("Location: admin_home.php");
        exit();
    }
    else{
        header("Location: admin_login.php?error=Incorrect username or password");
        exit();
    }
}

else{
    header("Location: admin_login.php");
    exit();
}