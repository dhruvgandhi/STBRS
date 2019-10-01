<?php
$date = $_GET["date"];
$bus_id = $_GET["bus_id"];

echo $date." ".$bus_id ;
if(isset($_GET["bus_id"]) && isset($_GET["email"]))
      {
        $bus_id = $_GET["bus_id"];
        $email = $_GET["email"];
        $cost = $_GET["cost"];
        $date = $_GET["date"];
        // Create connection
        $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=dhruv");
        echo $date;
        $sql = "INSERT INTO ticket(bus_id,email,cost,date) VALUES ('$bus_id', '$email', '$cost','$date')";
        $result = pg_query($conn, $sql);
        if (!$result) {
          echo "An error occurred.\n";
          exit;
        }
        $sql = "SELECT ticket_id FROM ticket WHERE bus_id='$bus_id' AND email='$email' AND cost='$cost' AND date='$date'";
        $result = pg_query($conn, $sql);
        if (!$result || pg_num_rows($result)<=0) {
          echo "An error occurred.\n";
          exit;
        }
        $row = pg_fetch_row($result);
        pg_close($conn);
        //header('Location: index.php');
        
        echo "<script>alert(\"Booked and Ticket ID:".$row[0]."\");document.location = \"index.php\";</script>";
}
?>