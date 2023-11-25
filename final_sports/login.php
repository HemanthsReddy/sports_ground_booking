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
    header( "Location: index.php?error=User Name is required ");
    exit();
}

if(empty($pass)) {
    header( "Location: index.php?error=Password is required ");
    exit();
}

$sql = "SELECT * FROM users WHERE username = '$uname' AND passwd= '$pass'";
$result = mysqli_query($conn, $sql);

$sql2 = "SELECT * FROM admins WHERE username = '$uname' AND passwd= '$pass'";
$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result)=== 1){
    $row = mysqli_fetch_assoc($result);
    if($row['username'] === $uname && $row['passwd'] === $pass){
        echo "Loggin in";
        $_SESSION['username'] = $row['username'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['mob_num'] = $row['mob_num'];
        header("Location: home4.php");
        exit();
    }
    else{
        header("Location: index.php?error=Incorrect username or password");
        exit();
    }
}
else{
    header("Location: index.php?error=Incorrect username or password");
    exit();
}



if(mysqli_num_rows($result2)=== 1){
    $row = mysqli_fetch_assoc($result2);
    if($row['username'] === $uname && $row['passwd'] === $pass){
        echo "Loggin in";
        $_SESSION['username'] = $row['username'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: admin_home.php");
        exit();
    }
    else{
        header("Location: index.php?error=Incorrect username or password");
        exit();
    }
}

else{
    header("Location: index.php");
    exit();
}