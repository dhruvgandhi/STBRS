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
      <script>
        function logOut()
        {
          <?php //session_destroy()?>;
          document.location.reload();
        }
      </script>
      <div class="topnav">
          <a class="active" href="index.php">LOGO</a>
          <a href="contact.php">Contact</a>
          <?php
                if(isset($_SESSION["email"]))
                {
            ?>
                    <a href="profileupdate.php">Profile</a>
                     <a style="float: right; color:darkorange" href="logout.php()"><?php echo $_SESSION["email"]; ?></a>
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
    <center><h2 class="container" style="color:red;">Bus Entry</h2></center><br/>
    <div class="container">
      <form action="busentry.php" id="stopentryform" method="POST">
        <label for="source">Source</label>
        <input type="text" placeholder="Enter Source" name="source" required>
        <label for="time1">Time</label>
        <input type="time" placeholder="Enter Time" name="time1" required></br></br>
        <label for="destination">Destination</label>
        <input type="text" placeholder="Enter Destination" name="destination" required>
        <label for="time2">Time</label>
        <input type="time" placeholder="Enter Time" name="time2" required></br></br>
        <label for="cost">Cost</label>
        <input type="number" placeholder="Enter Cost" name="cost" required></br></br>
        <div id="wrapper">
          <label>Stops In Between</label></br>
        </div>
        <input type="hidden" value="0" id="countOfStops" name="countOfStops">
        <input type="button" value="Add" onclick="add_fields()"></br></br>
        <input type="submit" value="Submit">
      </form>
    </div>
    <script>
      var stops = 3;
      function add_fields() {
          var dummy = '<span><input type="text" placeholder="Enter Stop" name="stop'+stops+'" required><input type="time" placeholder="Enter Time" name="time'+stops+'" required></br></br></span>';
          document.getElementById('wrapper').innerHTML += dummy; 
          stop++;
          document.getElementById('countOfStops').innerHTML = stop;
      }
    </script>
    <?php
      if(isset($_POST["source"])&&isset($_POST["destination"]))
      {
        $source = $_POST["source"];
        $cost = $_POST["cost"];
        $destination = $_POST["destination"];
        // Create connection
        $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
        if(!$conn)
        {
          echo "An error occurred.\n";
          exit;
        }
        
        //Insert Source and Dest
        $dest_id = (int)insertIfNotAvailable($destination,$conn);
        $source_id = (int)insertIfNotAvailable($source,$conn);
        $sql = "INSERT INTO bus(source,destination,cost) VALUES ($source_id,$dest_id,$cost)";
        $result = pg_query($conn, $sql);
        if (!$result) {
          echo "An error occurred.\n";
          exit;
        }

        //get bus_id
        $sql = "SELECT bus_id FROM bus WHERE source='$source_id' AND destination='$dest_id'";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result)<=0) {
          echo "An error occurred.\n";
          exit;
        }
        $row = pg_fetch_row($result);
        $bus_id = $row[0];

        //insert bus schedule
        //source & dest
        
        $time = $_POST["time1"];
        $time2 = $_POST["time1"];
        $sql = "INSERT INTO bus_schedule(time,bus_id,stop_id) VALUES ('$time','$bus_id',$source_id);
        INSERT INTO bus_schedule(time,bus_id,stop_id) VALUES ('$time2','$bus_id',$dest_id)";
        $result = pg_query($conn, $sql);
        if (!$result) {
          echo "An error occurred.\n";
          exit;
        }

        //for others
        for($i=3;$i<=$_POST["countOfStops"];$i++)
        {
          $stop_name = $_POST["stop".$i];
          $time = $_POST["time".$i];
          $stop_id = insertIfNotAvailable($stop_name,$conn);
          $sql = "INSERT INTO bus_schedule(time,bus_id,stop_id) VALUES ('$time','$bus_id',$stop_id)";
          $result = pg_query($conn, $sql);
          if (!$result) {
            echo "An error occurred.\n";
            exit;
          }
        }
      }
      function insertIfNotAvailable($name,$conn)
      {
        $sql = "SELECT stop_id FROM bus_stop WHERE name LIKE '$name'";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result)<=0 || !$result) {
          $sql = "INSERT INTO bus_stop(name) VALUES('$name')";
          $result = pg_query($conn, $sql);
          
        }
        $sql = "SELECT stop_id FROM bus_stop WHERE name LIKE '$name'";
        $result = pg_query($conn, $sql);
        if (pg_num_rows($result)<=0 || !$result)
          echo 'Error stop';
        $row = pg_fetch_row($result);
        echo 'Inserted/found Stop' .$row[0];
        return (int)$row[0];
      }
      

    ?>
  </body>

</html>