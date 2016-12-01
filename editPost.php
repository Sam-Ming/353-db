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

        <!--       jQuery UI Datepicker -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $( function() {
                $( "#datepicker" ).datepicker();
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
                ?>
                <a href="#">Support</a>
                <a href="#">About</a>
            </nav>
        </div>
    </header>

    <form method="post" action="/viewPosts.php">
        <div class="new_post">
            <h1 class="head">Edit Trip</h1>
            <div class="p">

                <label class="formName">Trip Title</label>
                <div class="textBoxWrapper">
                    <input type="text" id="formName" title="" value="" maxlength="100" class="inputBox">
                </div>

                <input type="text" id="datepicker" placeholder="Departure Date">
                <input title="" type="time" id="timepicker" value="00:00">

                <div class="textBoxWrapper">
                    <textarea id="formBody" title="" placeholder="Give a short description of your trip!"></textarea>
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

<?php
$servername = "vpc353_2.encs.concordia.ca";
$username = "vpc353_2";
$password = "A5DNm8";
$dbname = "vpc353_2";

try {
    $conn = new PDO("mysql:host=$servername;$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $sql = "INSERT INTO SAILORS (sname, rating, age)
//                VALUES ('John', '8', '18')";
//        $conn->exec($sql);
//        echo "New record created successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

$conn=null;
?>
