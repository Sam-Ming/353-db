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

    <!--       Source: jQuery UI Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker();
        } );
    </script>
    <!--end of Datepicker -->

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
            $_SESSION['role']=$_GET['role'];
            echo $_SESSION['role'];
            ?>
            <a href="#">Support</a>
            <a href="#">About</a>
        </nav>
    </div>
</header>

<!--        <form method="post" action="/post/generalTrip.php">-->
<form method="get" action="action_add.php">
    <div class="new_post">
        <h1 class="head">New Trip</h1>
        <div class="p">
            <?php
            echo"
                            <div name='type' value='".$_GET['type']."'></div>
                        ";
            ?>

            <label class="formName">Trip Title</label>
            <div class="textBoxWrapper">
                <input type="text" name="formName" id="formName" title="" value="" maxlength="100" class="inputBox">
            </div>

            <?php
            if ($_GET['type']=='regular'){
                echo "
                                <label class=\"formName\" style='margin-top: 5px'>Regular trip day</label>
                                <div class=\"textBoxWrapper\">
                                    <input type=\"checkbox\" name=\"weekday[]\" value=\"Monday\" />Monday
                                    <input type=\"checkbox\" name=\"weekday[]\" value=\"Tuesday\" />Tuesday
                                    <input type=\"checkbox\" name=\"weekday[]\" value=\"Wednesday\" />Wednesday
                                    <input type=\"checkbox\" name=\"weekday[]\" value=\"Thursday\" />Thursday
                                    <input type=\"checkbox\" name=\"weekday[]\" value=\"Friday\" />Friday
                                    <input type=\"checkbox\" name=\"weekday[]\" value=\"Saturday\" />Saturday
                                    <input type=\"checkbox\" name=\"weekday[]\" value=\"Sunday\" />Sunday
                                </div>
                            ";
            }else{
                echo "
                                <div class=\"textBoxWrapper\">
                                    <input type=\"text\" class=\"datepicker\" name=\"date\" placeholder=\"Departure Date\">
                                </div>
                            ";
            }
            ?>

            <div class="textBoxWrapper">
                <div class="styled-select">
                    <?php
                    include_once ('connection.php');
                    $con = new Connection();
                    $con->displaySelectList('cityName','city','Arrival city','dCity');
                    ?>
                </div>
                <input type="text" placeholder="Departure Postal Code" name="dPostal" class="postal" maxlength="6">
            </div>

            <div class="textBoxWrapper">
                <div class="styled-select">
                    <?php
                    $con->displaySelectList('cityName','city','Departure city','aCity');
                    $con->close();
                    ?>
                </div>
                <input type="text" placeholder="Arrival Postal Code" name="aPostal" class="postal" maxlength="6">
            </div>

            <div class="restriction">
                <input title="" type="checkbox" name="restriction" value="1">
                Would you like to restrict the travel area?<br>
                <input title="" type="hidden" name="restriction" value="0">
            </div>



            <div class="textBoxWrapper">
                <textarea id="formBody" name="formBody" title="" placeholder="Give a short description of your trip!"></textarea>
            </div>

            <div class="agreement">
                By adding this post, you must agree to the terms of the
                <a href="https://google.com"
                   target="_new">license agreement</a>.
            </div>

            <input type="submit" id="addPost" value="Post Trip">
        </div>
    </div>
</form>
</body>
</html>