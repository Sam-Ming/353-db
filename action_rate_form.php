<?php if(session_status()==PHP_SESSION_NONE){
session_start();
}

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

$servername = "vpc353_2.encs.concordia.ca";
$username = "vpc353_2";
$password = "A5DNm8";
$dbname = "vpc353_2";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

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
                echo"<a>Welcome ".$_SESSION['userName'].", </a>
                     <a href=\"logout.php?logout=true\">Log out</a>";
            }else{
                echo"<a href=\"login.php\">Log in</a>";
            }
            ?>
            <a href="#">Support</a>
            <a href="#">About</a>
        </nav>
    </div>
</header>



<!-- create a condition, if exists, say you can only rate once
-->


<form method="get" action="action_rate_result.php">
    <div class="new_post">
        <h1 class="head">Please fill out the rating form</h1>
        <div class="p">
            <?php
            $ID = $_GET['subject1'];
            $type = $_GET['subject2'];
            echo"Type: " . $type. "<p>". " ID: " . $ID;



            ?>

            <input type='hidden' name='ID' value='<?php echo "$ID";?>'/>
            <input type='hidden' name='type' value='<?php echo "$type";?>'/>

            <label class="formName">Give a rate from 1 to 10</label>
            <div class="textBoxWrapper">
                <input type="number" name="rating" id="rating" title="" value="" min="1" max="10" class="inputBox">
            </div>

            <div class="textBoxWrapper">
                <label>Do you wish to complaint?</label>
            <input type="radio" name="complaint" value="true">Yes
                <input type="radio" name="complaint" value="false" checked>No
            </div>

            <div class="textBoxWrapper">
                <textarea id="comments" name="comments" title="" placeholder="Give a short description of your rating!"></textarea>
            </div>





            <input type="submit" id="" value="Post Rating Form">
        </div>
    </div>
</form>



<?php



/*

*/
?>



</body>
</html>

