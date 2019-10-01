<!-- by JJ-->
<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/topnav.css" type="text/css">
    <link rel="stylesheet" href="css/contact.css" type="text/css">
    <link rel="icon" href="res/logo.png" type="image/gif" sizes="16x16">
  </head>
  
  <body class="bg"> 
  <script>

    </script>
      <div class="topnav">
          <a class="active" href="index.php">LOGO</a>
          <a href="contact.php">Contact</a>
            <?php
                if(isset($_SESSION["email"]))
                {
            ?>
                    <a href="profileupdate.php">Profile</a>
                    <a style="float: right; color:darkorange" href="logout.php"><?php echo $_SESSION["email"]; ?></a>
            <?php
                }
                else
                {
            ?>
                    <a style="float: right; color:darkorange" href="login.php">Login</a>
                    <a style="float: right; color: aquamarine" href="register.php">Register</a>
            <?php
                }
            ?>
      </div>
    <br>
    <center><h2 class="container" style="color:red;">LOGIN</h2></center><br/>
    <br/>
    <div class="container">
    <form action="login.php" method="POST">
        <label for="email">Username</label><br/>
        <input type="email" placeholder="Enter email" name="email" required><br/>
        <label for="psw">Password</label><br/>
        <input type="password" placeholder="Enter Password" name="psw" required><br/>
        <input type="submit" value="Login"><br/>
        <label style="padding-left: 15px">
        <!--input type="checkbox"  checked="checked" name="remember"> Remember me
        </label><br>
        <span class="psw"><a href="baaakiiiiiiii!!!!!"> Forgot password?</a></span>-->
    </form>
    </div>
    <?php
        echo "hello".$_SESSION["email"];
        if(isset($_POST["psw"]) && isset($_POST["email"]))
        {
            $email = $_POST["email"];
            $psw = $_POST["psw"];
            $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
            $sql = "SELECT u_type FROM user_info WHERE email='$email' AND passw='$psw'";
            $result = pg_query($conn, $sql);
            pg_close($conn);
            if (!$result) {
            exit("An error occurred");
            } elseif(pg_num_rows($result)<=0) {
                //header('Location: register.php');
                exit( "No user found");
            } else {
                $row = pg_fetch_row($result);
                $_SESSION["email"]=$email;
                if($row[0]==false)
                {
                  echo "Admin";
                  $_SESSION["u_type"]="admin";
                }
                //header('Location: index.php');
                echo "Welcome ".$_SESSION["email"];
            }
        }
    ?>
  </body>
</html>