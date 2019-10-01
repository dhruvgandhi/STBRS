<!-- BY PJ-->
<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/topnav.css" type="text/css">
  <link rel="stylesheet" href="css/contact.css" type="text/css">
  <link rel="icon" href="res/logo.png" type="image/gif" sizes="16x16">
</head>
<body class="bg">
    <div class="topnav">
        <a  href="index.php">LOGO</a>
        <a class="active"href="contact.php">Contact</a>
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
    </br>
    <center><h2 class="container" style="color:red;">CONTACT US</h2></center></br>
<div class="container">
  <form action="#">
    First Name
    <input type="text" id="fname" name="firstname" placeholder="Your name" required>
    Last Name
    <input type="text" id="lname" name="lastname" placeholder="Your last name" required>
	  Email
	  <input value="<?php if(isset($_SESSION["email"])){echo $_SESSION["email"];}?>" type="text" id="email" name="email_id" placeholder="Enter your email_id" required>
    Feedback
    <textarea id="subject" name="subject" placeholder="Write something" style="height:200px" required></textarea>
    <button value="Submit">
  </form>
</div>
<?php
?>

</body>
</html>
