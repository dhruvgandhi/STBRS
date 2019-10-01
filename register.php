<!-- by JJ-->
<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <title>Registraion form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/topnav.css" type="text/css">
    <link rel="stylesheet" href="css/contact.css" type="text/css">
    <link rel="icon" href="res/logo.png" type="image/gif" sizes="16x16">
    
  </head>
  <body class="bg">
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
    <center><h2 class="container" style="color:red;">REGISTER</h2></center><br/>
    <div class="container">
      <form action="register.php" method="POST">
        <label for="uname">Fullname</label>
        <input type="text" placeholder="Enter Fullname" name="fname" required>
        <label for="email">Email id</label>
        <input type="email" placeholder="Enter Email address" name="email" required>
        <label for="psw">Password</label>
        <input type="password" placeholder="Enter Password" name="psw" required>
        <label for="phone_no">Phone</label>
        <input type="tel" placeholder="Enter Phone" pattern="[0-9]10"name="phone_no" required>
        <input type="submit" value="Submit">
      </form>
    </div>
    <?php
      if(isset($_POST["psw"])&&isset($_POST["email"])&&isset($_POST["fname"]))
      {
        $fullname = $_POST["fname"];
        $email = $_POST["email"];
        $psw = $_POST["psw"];
        $phone_no = $_POST["phone_no"];
        // Create connection
        $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
        $sql = "INSERT INTO user_info(fname,email,passw,phone_no,u_type) VALUES ('$fullname', '$email', '$psw','$phone_no','true')";
        $result = pg_query($conn, $sql);
        if (!$result) {
          echo "An error occurred.\n";
          exit;
        }
        pg_close($conn);
        $_SESSION["email"]=$email;
        header('Location: index.php');
      }
      

    ?>
  </body>

</html>