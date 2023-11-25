<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet"  href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="signup_process.php" method="post">
            <div class ="form-group">
                <h2>Sign Up</h2>
            </div>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
            <?php } ?>
            <!-- <label for="fname">First Name</label> -->
            <div class="form-group">
                <input type="text" class="form-control" name="fname" placeholder="First Name" required>
            </div>    
            <!-- <label for="lname">Last Name</label> -->
            <div class="form-group">
                <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
            </div>    
            <!-- <label for="username">Username</label> -->
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>    
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>    
            <div class="form-group">
                <input type="text" class="form-control" name="mob_num" placeholder="Mobile Number">
            </div>  

            
            <div class="form-group">
                <select name="gender" class= "form-control">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div> 

            <div class="center">
            <div class= "form-group">
            <button type="submit" class="btn btn-primary">Sign Up</button>
            </div> 
            </div> 
            <!-- <input type="submit" class="btn btn-primary" name= "submit"> -->
        </form>
    </div>
</body>
</html>
