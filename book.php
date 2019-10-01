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
    <script>
        var date = new Date();
        var res = document.getElementById(date.getHours()+":"+date.getMinutes()+":"+date.getSeconds());
        if(res!=null)
            res.scrollIntoView();

    </script>
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
      <?php>
      <?>
      <br/>
      <div class="container">
                <?php
                    $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
                    $sql = "SELECT bus_id FROM bus_schedule WHERE sch_id='".$_GET['schedule']."'";
                    $result = pg_query($conn, $sql);
                    pg_close($conn);
                    if (!$result) {
                    exit("An error occurred");
                    } elseif(pg_num_rows($result)<=0) {
                        //header('Location: register.php');
                        exit( "No user found");
                    } else {
                        $row=pg_fetch_row($result);
                        $bus_id=$row[0];
                    }
                ?>
                <label for="email">Email:</label>
                <input disabled type="text" id="email" name="email" value="<?php echo $_SESSION['email'] ?>"><br/><br/>
                <?php
                    if(!isset($_SESSION['email']))
                    {
                        header("location: login.php");
                    }
                    $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
                    $sch = $_GET['schedule'];
                    $sql = "SELECT bus_id FROM bus_schedule WHERE sch_id=$sch";
                    $result = pg_query($conn, $sql);
                    
                    if (!$result) {
                    exit("An error occurred");
                    } elseif(pg_num_rows($result)<=0) {
                        //header('Location: register.php');
                        exit( "No user found");
                    } else {
                        
                        $row=pg_fetch_row($result);
                        //echo "found".$row[0];
                        $bus_id=$row[0];
                        //$cost = $row[1];
                    }
                    $sql = "SELECT cost FROM bus WHERE bus_id=$bus_id";
                    $result = pg_query($conn, $sql);
                    pg_close($conn);
                    if (!$result) {
                    exit("An error occurred");
                    } elseif(pg_num_rows($result)<=0) {
                        //header('Location: register.php');
                        exit( "No user found");
                    } else {
                        
                        $row=pg_fetch_row($result);
                        //echo "found".$row[0]
                        $cost = $row[0];
                    }
                ?>
                <label for="bus_id">Bus_ID:</label>
                <input disabled type="text" id="bus_id" name="bus_id" value="<?php echo $bus_id?>"><br/><br/>

                <input type="date" id="date" name="date"><br/>
                <hr/>
                <label for="cost"><h2>Cost:</h2></label>
                <input disabled type="text" id="cost"name="cost" value="<?php echo $cost ?>">
                <input type="button" style="background-color: green;" onclick="confirmBook()" value="confirm">
            <script>
                function confirmBook()
                {
                    var s = "confirmbook.php?";
                    s += "email="+document.getElementById("email").value+"&";
                    s += "bus_id="+document.getElementById("bus_id").value+"&";
                    s += "cost="+document.getElementById("cost").value+"&";
                    s += "date="+document.getElementById("date").value+"&";
                    document.location=""+s;
                }
            </script>
      </div>
    </body>
</html>