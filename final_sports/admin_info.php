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
            <title>Admin Information</title>
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

        
        
        <a href="admin_grounds.php" class="update-btn">View Grounds</a> 
        <a href="admin_reviews.php" class="update-btn">View Reviews</a>  
        <a href="admin_home.php" class="back-btn">Back to Home</a>
        <a href="logout.php" class="back-btn-logout">Logout</a> 
         
    </div>

       

           
        </body>
    </html>

