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
        var elements = document.body.getElementsByClassName("*"+date.getHours()+"*");
        //var res = document.getElementById(date.getHours()+":"+date.getMinutes()+":"+date.getSeconds());
        if(elements[0]!=null)
            elements[0].scrollIntoView();

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
    
        <?php
            if(isset($_GET["source"]) && isset($_GET["destination"]))
            {
                $source = $_GET["source"];
                $destination = $_GET["destination"];
                $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
                $sql = "SELECT * FROM bus WHERE source IN (SELECT stop_id FROM bus_stop WHERE name LIKE lower('$source')) AND destination IN (SELECT stop_id FROM bus_stop WHERE name LIKE lower('$destination'))";
                $result = pg_query($conn, $sql);
                if (!$result) 
                {
                    exit("An error occurred");
                } 
                elseif(pg_num_rows($result)<=0) 
                {
                    //header('Location: register.php');
                    exit( "<script>alert('No Results');document.location = \"index.php\";</script>");
                } 
                else 
                {
                    while($row = pg_fetch_row($result)) 
                    {
                        $sql = "SELECT sch_id,time FROM bus_schedule WHERE bus_id='$row[0]' AND stop_id='$row[1]' ";
                        echo $row[0]. "  " .$row[1];
                        createResults($conn,$sql);
                        
                    }
                }
                pg_close($conn);
            }
            function createResults($conn,$sql)
            {
                
                $result2 = pg_query($conn, $sql);
                if(pg_num_rows($result2)>0)
                {

                }
                while($row2 = pg_fetch_row($result2)) 
                {
                    echo "<div class=\"container\" id=\"".$row2[1]."\"><a class=\"".$row2[1]."\"href=\"book.php?schedule=".$row2[0]."\">DEPARTURE: ". $row2[1] . "</a></div></br>";
                }
            }
        ?>
    </body>
</html>