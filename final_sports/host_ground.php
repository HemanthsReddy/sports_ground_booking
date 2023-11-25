<?php
session_start(); // Start the session

// Check if the username is set in the session
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    // Redirect or handle unauthorized access
    header("Location: index.php"); // Redirect to login page or handle unauthorized access
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="host_ground_process.php" method="post" enctype="multipart/form-data">
            <div class ="form-group">
                <h2>ADD GROUND</h2>
            </div>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
            <?php } ?>
            
            <div class="form-group">
                <input type="text" class="form-control" name="gname" placeholder="Ground Name" required>
            </div>    

            <div class="form-group">
                <input type="text" class="form-control" name="loc" placeholder="Location" required>
            </div>    

            <div class="form-group">
                <input type="text" class="form-control" name="price" placeholder="Price" required>
            </div>    

            <div class="form-group">
                <select class="form-select" name="sid" required>
                    <option value="" selected disabled>Select Sport</option>
                    <?php
                    include_once 'db_connection.php';
                    $query = "SELECT sport_id, sport_name FROM sports";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['sport_id'] . "'>" . $row['sport_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="gowner" placeholder="Owner" value="<?php echo $_SESSION['username']; ?>" readonly>
            </div> 

            <div class="form-group">
                <input type="file" name="image">
            </div>  

            <div class="center">
                <div class= "form-group">
                    <button type="submit" class="btn btn-primary">ADD GROUND</button>
                </div> 
            </div> 
        </form>
    </div>
</body>
</html>
