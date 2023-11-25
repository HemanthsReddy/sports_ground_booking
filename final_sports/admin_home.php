<?php
session_start();
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="home4.css">
</head>
<body>
    <header>
        <h1>Welcome to the Sports Ground Booking System</h1>
        <h1>PLAYO</h1>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="book_ground4.css">
    </header>
    
    <div class="button-container">
        <a href="admin_info.php"><button>Admin Profile</button></a>
        <a href="host_ground.php"><button>Host Ground</button></a>
        <a href="Logout.php"><button>Logout</button></a>
    </div>
</body>
</html>
