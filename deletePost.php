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
            ?>
            <a href="#">Support</a>
            <a href="#">About</a>
        </nav>
    </div>
</header>

<p class="success" style="text-align: center">
<h1>Delete Posts by Trip Number</h1>

        <?php
                    $servername = "vpc353_2.encs.concordia.ca";
                    $username = "vpc353_2";
                    $password = "A5DNm8";
                    $dbname = "vpc353_2";
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);


                    $sql = "SELECT tid FROM trip";
                    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

                $TID =  $row["tid"];

                echo "Trip ID: " . $row["tid"]. "<br>";
                echo '<a href="action_delete.php?subject='.$TID.'">Yes, delete!</a><p>';
            }
        } else {
            echo "0 results";
        }

        ?>



</body>
</html>
