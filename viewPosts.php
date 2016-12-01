<?php if(session_status()==PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

<header class="header-basic">
    <link rel="stylesheet" type="text/css" href="assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/addPost.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/main.css"/>

    <div class="header-limiter">

        <h1><a href="index.php">Su<span>per</span></a></h1>

        <nav>
            <?php
            if(isset($_SESSION['user'])){
                echo"
                <a>Welcome ".$_SESSION['userName'].
                    ", </a>
                <a href=\"logout.php?logout=true\">Log out</a>
                ";
            }else{
                echo"
                <a href=\"login.php\">Log in</a>
                ";
            }
            $MID = $_SESSION['user'];
            $_SESSION['role']=$_GET['role'];
            $role = $_SESSION['role'];
            ?>
            <a href="#">Support</a>
            <a href="#">About</a>
        </nav>
    </div>
</header>

<div class="match" style="text-align: center">
<p class="success" style="text-align: center">
    <?php

        $servername = "vpc353_2.encs.concordia.ca";
        $username = "vpc353_2";
        $password = "A5DNm8";
        $dbname = "vpc353_2";

        if($role=='rider'){
            $role=0;
        }else{
            $role=1;
        }

            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM trip WHERE authorID='$MID' 
                    AND role=$role";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {

                    $TID =  $row["TID"];
                    $_SESSION['location'] = $row['dCity'].' to '.$row['aCity'];

                    echo "<br><div class='serviceContent'>";
                    echo "Trip ID: ".$row['TID'];
                    echo "<br>Title: ".$row['Title'];
                    echo "<br>Departure Date: ".$row['dDate'];
                    echo "<br>Departure Postal Code: ".$row['dPostal'];
                    echo "<br>Arrival Postal Code: ".$row['aPostal'];
                    echo "<br>Description: ".$row['Description'];
                    $city = $row["dCity"];
                    if ($row['Restriction']){
                        $city2 = $this->conn->query("SELECT * FROM city WHERE cityName='$city'");
                        echo "<br>Restricted to drivers from the following regions: ";
                        while ($row2 = $city2->fetch_assoc()) {
                            echo $row2['citySurrounded'];
                        }
                    }
                    echo "</div>";
                    echo '<a href="matchPost.php?match='.$TID.'">Find a match for your trip now!</a><p>';
                }
            } else {
                echo "<br><span style='color:orangered;'>You do not </span>have any trip yet!";
            }

            $conn->close();

    ?>
</p>
</div>

</body>
</html>
