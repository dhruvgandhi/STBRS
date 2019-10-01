<?php session_start();?>
<html>
    <head>
        <title>STBRS</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="css/topnav.css" type="text/css">
            <link rel="stylesheet" href="css/searchbar.css" type="text/css">
            <style>
                .container{
                    border-radius :5px;
                    background-color :#f2f2f2;
                    padding: 10px;
                    width: 70% ;
                    position: relative;
                    margin: auto;
                    box-shadow: 2px 3px #FD5F3D;
                    text-align:center;
                }
            </style>
            <link rel="icon" href="res/logo.png" type="image/gif" sizes="16x16">
    </head>
    <body class="bg">
        <div class="topnav" id="myTopnav">
            <a class="active" href="index.php"><div class="logo">Home</div></a>
            <a href="contact.php">Contact</a>
            <?php
                if(isset($_SESSION["email"]))
                {
                    if(isset($_SESSION["u_type"]) && $_SESSION["u_type"]=="admin")
                    {
            ?>
                        <a href="busentry.php">Bus Data</a>
                    <?php } ?>
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
        <script>
            /* function myFunction() {
              var x = document.getElementById("myTopnav");
              if (x.className === "topnav") {
                x.className += " responsive";
              } else {
                x.className = "topnav";
              }
            } */
            function logOut()
            {
                <?php //session_destroy()?>;
                document.location.reload();
            }
            function showHint(str,a) 
            {
                if (str.length == 0) {
                    if(a)
                    {
                        document.getElementById("txtHint").innerHTML = "";
                    }
                    else
                        document.getElementById("txtHint2").innerHTML = "";
                    return;
                } else {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            if(a)
                            {
                                document.getElementById("txtHint").innerHTML = this.responseText;
                                document.getElementById("txtHint").value = this.responseText;
                            }
                            else
                            {
                                document.getElementById("txtHint2").innerHTML = this.responseText;
                                document.getElementById("txtHint2").value = this.responseText;
                            }
                                
                        }
                    };
                    xmlhttp.open("GET", "gethint.php?q=" + str, true);
                    xmlhttp.send();
                }
            }
        </script>
            

        <script>
            function usehint(id)
            {
                if(id=="txtHint")
                {

                    document.getElementById("source").value = document.getElementById(id).value;
                }
                else
                {
                    document.getElementById("destination").value = document.getElementById(id).value;
                }
            }
        </script>
            <form class="searchbar" action="search.php" method="GET">
                <input type="text" name="source" id="source" class="bar" placeholder="Source" onkeyup="showHint(this.value,true)" required/>&nbsp
                <span class="container"  id="txtHint" onclick="usehint(this.id)"></span>
                <input type="text" class="bar" name="destination" id="destination" placeholder="Destination" onkeyup="showHint(this.value,false)" required/>&nbsp
                <span class="container"  id="txtHint2" onclick="usehint(this.id)"></span>
                <button type="submit" class="searchbutton">Search</button></br>
            </form>
    </body>
</html>