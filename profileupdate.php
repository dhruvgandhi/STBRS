<!-- BY JJ-->
<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
  <?php
    if(isset($_SESSION["email"]))
    {
        $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
        $sql = "SELECT fname,email FROM user_info WHERE email='".$_SESSION["email"]."'";
        $result = pg_query($conn, $sql);
        if (!$result || pg_num_rows($result)<=0) {
          echo "An error occurred.\n";
          exit;
        }
        else
        {
            $row = pg_fetch_row($result);
            $fname = $row[0];
            $email = $row[1];
        }
        if(isset($_POST["phone_no"]))
        {
          $phone_no = $_POST["phone_no"];
          // Create connection
          $sql = "UPDATE user_info SET phone_no = '$phone_no' WHERE email = '$email'";
          $result = pg_query($conn, $sql);
          if (!$result) {
            echo "An error occurred.\n";
            exit;
          }
          echo "<script>alert(\"Contact Updated\");</script>";
        }
        pg_close($conn);
    }
?>
    <title>Updation form</title>
    <link rel="stylesheet" href="css/contact.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/topnav.css" type="text/css">
  </head>

  <body>
  <div class="topnav" id="myTopnav">
            <a class="active" href="index.php"><div class="logo">Home</div></a>
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
            <!-- <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a> -->
        </div>
    <form action="profileupdate.php" method="POST">
      <h1 class="container" style="text-align:center;">PROFILE UPDATION</h1>
 <br>
      <div class="container">
        <label for="fname"><strong>FULL NAME</strong></label>
        <input type="text" disabled placeholder="Enter your full name" name="fname" value="<?php echo $fname ?>">

<label for="email"><strong>EMAIL</strong></label>
        <input type="email" disabled placeholder="Enter the email_id" name="email" value="<?php echo $email ?>">


        <label for="phone_no"> <strong>CONTACT NUMBER</strong></label><span>     [Format: 4586567968]</span>
        <input type="tel" placeholder="Enter the contact number" name="phone_no" pattern="[0-9]{10}" required>


    <input type="submit">

      </div>
    </form>



  </body>
</html>
