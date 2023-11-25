<!DOCTYPE html>
<html>
    <head>
        <title> LOGIN </title>
        <link rel="stylesheet"  href="index_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">
        <form action="login.php" method="post">
        
            <h2>USER LOGIN</h2>
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
             <p style="color: aliceblue">Don't have an account? <a href="signup.php">Sign Up</a></p>
             <p style="color: aliceblue">Are you an admin? <a href="admin_login.php">Admin login</a></p>
             </div> 

        </form>
        </div>
    </body>
</html>