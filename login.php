<?php
ob_start();
session_start();
require_once 'dbconnect.php';
// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user'])!="" ) {
	header("Location: index.php");
	exit;
}
$error = false;
if( isset($_GET['btn-login']) ) {
	// prevent sql injections/ clear user invalid inputs
	$email = trim($_GET['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);
	$pass = trim($_GET['pass']);
	$pass = strip_tags($pass);
	$pass = htmlspecialchars($pass);
	// prevent sql injections / clear user invalid inputs
	if(empty($email)){
		$error = true;
		$emailError = "Please enter your email address.";
	} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$error = true;
		$emailError = "Please enter valid email address.";
	}
	if(empty($pass)){
		$error = true;
		$passError = "Please enter your password.";
	}
	// if there's no error, continue to login
	if (!$error) {
		$password = hash('sha256', $pass); // password hashing using SHA256
		$res=mysql_query(sprintf("SELECT MID, Username, Password FROM account WHERE Email='%s' AND Password = '%s'",
			mysql_real_escape_string($email),
			mysql_real_escape_string($password)
		));
		$row=mysql_fetch_array($res);
		$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
		$query2 = mysql_query(sprintf("SELECT DISTINCT Status FROM member M, account A WHERE (A.Email='%s' 
			AND A.Password = '%s') AND (M.MID = A.MID)",//" AND (M.Status = 1)",
			mysql_real_escape_string($email),
			mysql_real_escape_string($password)
		));
		$stat = mysql_fetch_assoc($query2);
		if($count == 1) { //&& $row['Password']== $password ) {
			if ($stat['Status'] == 1)
			{
				$_SESSION['user'] = $row['MID'];
				$_SESSION['userName'] = $row['Username'];
				header("Location: index.php");
			}
			else
			{
				if($stat['Status'] == 0)
				{
					$errMSG = "This account has been Suspended.  Access Rights revoked.";
				}
				else
				{
					$errMSG = "This account is flagged as Inactive.  Contact an admin.";
				}
			}
		} else {
			$errMSG = "Incorrect Credentials, Try again...";
		}
	}
}
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Coding Cage - Login & Registration System</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
		<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
	</head>
	<body>

	<div class="container">

		<div id="login-form">
			<form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

				<div class="col-md-12">

					<div class="form-group">
						<h2 class="">Sign In.</h2>
					</div>

					<div class="form-group">
						<hr />
					</div>

					<?php
					if ( isset($errMSG) ) {
						?>
						<div class="form-group">
							<div class="alert alert-danger">
								<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
							</div>
						</div>
						<?php
					}
					?>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
						</div>
						<span class="text-danger"><?php echo $emailError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
						</div>
						<span class="text-danger"><?php echo $passError; ?></span>
					</div>

					<div class="form-group">
						<hr />
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
					</div>

					<div class="form-group">
						<hr />
					</div>

					<div class="form-group">
						<a href="register.php">Sign Up Here...</a>
					</div>

				</div>

			</form>
		</div>

	</div>

	</body>
	</html>
<?php ob_end_flush(); ?>
