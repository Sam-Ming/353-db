<?php
/**
 * Created by PhpStorm.
 * User: aaronchen
 * Date: 2016-11-10
 * Time: 12:43 PM
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body>

    <header class="header-basic">
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="stylesheet" type="text/css" href="css/addPost.css"/>


        <div class="header-limiter">

            <h1><a href="index.php">Su<span>per</span></a></h1>

            <nav>
                <a href="#">Support</a>
                <a href="#">Log in</a>
                <a href="#">About</a>
            </nav>
        </div>
    </header>

    <p class="success" style="text-align: center">
        <p>Delete Posts by Trip Number</p>
        <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "trip";
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);


                    $sql = "SELECT tid FROM trip";
                    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

                /* Link the TID from deletedPost.php to delete.php
                    still have errors
                    -*/
                $myVar = $row["tid"];

                echo "Trip ID: " . $row["tid"]. "<br>";
                echo '<a href="deleted.php?subject='.$row["tid"].'">Click here to delete.</a> <p>';
            }
        } else {
            echo "0 results";
        }

        ?>
</p>

</body>
</html>




//SAM HELLLO look here ***********************************