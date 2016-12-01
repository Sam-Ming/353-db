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
        <meta http-equiv=REFRESH CONTENT=5;url=matchPost.php>

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
    <?php
    include_once ('connection.php');
    if(isset($_GET['formName']) and isset($_GET['dCity']) and isset($_GET['formBody'])){
        try {
            $con = new Connection();
            $authorID=$_SESSION['user'];
            $role = $_SESSION['role'];
            $status='';
            if($role=='rider'){
                $status=0;
            }else{
                $status=1;
            }
            if(isset($_GET['weekday'])){
                $dDate=implode(",", $_GET['weekday']);;
                $category = 'regular';
                echo "weekday";
            }else{
                $dDate=$_GET['date'];
                $category = 'onetime';
            }
            $dCity=$_GET['dCity'];
            $aCity=$_GET['aCity'];
            $dPostal=$_GET['dPostal'];
            $aPostal=$_GET['aPostal'];
            $Description=$_GET['formBody'];
            $Restriction=$_GET['restriction'];
            $Title=$_GET['formName'];
            $sql = "INSERT INTO trip (authorID,dDate,dCity,aCity,dPostal,aPostal,Description,Restriction,Title, Category, Role)
                        VALUES ('$authorID','$dDate','$dCity','$aCity','$dPostal','$aPostal','$Description',
                        '$Restriction','$Title', '$category', '$status')";
            $con->setQuery($sql);
            $_SESSION['newPost']=$con->getLastID();
            echo '
                      Your trip has been added <span style="color:#1bcd00;">successfully</span> 
                      posted, you will be redirected in 5 seconds.
                      ';
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
        $conn=null;
    }
    ?>
</p>

</body>
</html>

