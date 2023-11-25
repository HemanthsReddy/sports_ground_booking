<!DOCTYPE html>
<html>
    <head>
        <title> ADMIN LOGIN </title>
        <link rel="stylesheet"  href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">
        <form action="admin_login_process.php" method="post">
        
            <h2>ADMIN LOGIN</h2>
            <?php if(isset($_GET['error']))  { ?> 
                <p class="error"> <?php echo $_GET['error']; ?></p>

             <?php } ?>
             <!-- <label for="">User Name</label> -->
             <div class ="form-group">
             <input type="text" class="form-control" name="uname" id="" placeholder="User Name"> <br>
             </div> 
             <!-- <label>Password</label> -->
             <div class ="form-group">
             <input type="password" class="form-control" name="password" placeholder="Password"> <br>
             </div>

             <div class ="form-group">
             <button type="submit" class="btn btn-primary">Login</button>
             </div> 

             <div class ="form-group">
             <p style="color: aliceblue">Don't have an account? <a href="admin_signup.php">Sign Up</a></p>
             <p style="color: aliceblue">Are you an User? <a href="index.php">User login</a></p>
             </div> 

        </form>
        </div>
    </body>
</html>