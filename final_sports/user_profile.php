<?php
session_start();

if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Information</title>
            <link rel="stylesheet" href="user_profile.css">
        </head>
        <body>
        <div class="container">
        <h2>User Information</h2>

            <table>
                <tr>
                    <th>Username</th>
                    <td><?php echo $_SESSION['username']; ?></td>
                </tr>
                <tr>
                    <th>First Name</th>
                    <td><?php echo $_SESSION['fname'];?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?php echo $_SESSION['lname']; ?></td>
                </tr>
                <tr>
                    <th>Mobile Number</th>
                    <td><?php echo $_SESSION['mob_num']; ?></td>
                </tr>
                
            </table>

        <a href="update_user.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="update-btn">Update User Information</a>
        <a href="user_bookings.php" class="update-btn">View Bookings</a>  
        <a href="home4.php" class="back-btn">Back to Home</a>  
        <a href="user_reviews.php" class="update-btn">Your Reviews</a>
        <a href="logout.php" class="back-btn-logout">Logout</a>  
    </div>

       

           
        </body>
    </html>
    <?php
}
else{
    header("Location: index.php");
    exit();
}