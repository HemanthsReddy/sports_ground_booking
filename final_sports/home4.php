<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="home4.css">
</head>
<body>
    <header>
    <img style="margin-left: 50px;  max-width: 50%; 
            max-height: 20vh;" src="logo.png" alt="Logo">
        <h1>Welcome to the Sports Ground Booking System</h1>
        <h1>PLAYO</h1>
    </header>

    <div class="button-container">
        <a href="user_profile.php"><button>User Profile</button></a>
        <a href="book_ground4.php?search="><button>Book Ground</button></a>
        <a href="logout.php"><button>Logout</button></a>
    </div>

    <div class="search-container">
    <p class="search-info">Ready to find SPORTS COMPLEXES near you</p>
        <form action="book_ground4.php" method="get">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search Grounds.../ Sports..." value="">
                <button type="submit">Search</button>
            </div>
            <!-- Additional text below the search box -->
            <p class="search-info">Enter keywords to find your desired sports ground.</p>
        </form>
    </div>
</body>
</html>
