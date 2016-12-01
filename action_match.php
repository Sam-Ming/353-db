<?php if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }
    $postID = $_SESSION['newPost'];
    $matchID = $_GET['match'];
    $role = $_SESSION['role'];
    $MID = $_SESSION['user'];

    if($role=='rider'){
        $role=2;
        $matchedRole=3;
    }else{
        $role=3;
        $matchedRole=2;
    }

    include_once ('connection.php');

    $con=new Connection();
    $query="SELECT balance FROM account WHERE MID='$MID' balance>=70";
    $con->setQuery($query);
    $con->execute();
    $balance=$con->getResult();

    if(isset($balance) and $balance!=null){

    $con = new Connection();
    $query="UPDATE trip SET matchedID='$matchID', role=$role WHERE TID='$postID'";
    $con->setQuery($query);
    $con->execute();
    $query="UPDATE trip SET matchedID='$postID', role=$matchedRole WHERE TID='$matchID'";
    $con->setQuery($query);
    $con->execute();
    $con->close();

    }else{
        $message="You do not have enough balance in your account!";
        header("Location: matchPost.php?Message=" . urlencode($message));
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv=REFRESH CONTENT=10;url=action_pay.php>

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

<p class="success" style="text-align: center">
    Your trip has been <span style="color:#1bcd00;">successfully</span>
    matched, you will be redirected to payment page in 10 seconds.

</p>



</body>
</html>

