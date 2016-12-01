<?php
	ob_start();
	session_start();
	if( isset($_SESSION['user'])!="" ){
		header("Location: index.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	// test
	echo $_POST['btn-signup'];

	if ( isset($_POST['btn-signup']) ) {

		// clean user inputs to prevent sql injections
		$name = trim($_POST['name']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);

		$fName = trim($_POST['fName']);
		$fName = strip_tags($fName);
		$fName = htmlspecialchars($fName);

		$lName = trim($_POST['lName']);
		$lName = strip_tags($lName);
		$lName = htmlspecialchars($lName);

		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);

		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);

		$dob = trim($_POST['dob']);
		$dob = strip_tags($dob);
		$dob = htmlspecialchars($dob);

		$address1 = trim($_POST['address1']);
		$address1 = strip_tags($address1);
		$address1 = htmlspecialchars($address1);

		$address2 = trim($_POST['address2']);
		$address2 = strip_tags($address2);
		$address2 = htmlspecialchars($address2);

		$city = trim($_POST['city']);
		$city = strip_tags($city);
		$city = htmlspecialchars($city);

		$postal = trim($_POST['postal']);
		$postal = strip_tags($postal);
		$postal = htmlspecialchars($postal);

		$province = trim($_POST['province']);
		$province = strip_tags($province);
		$province = htmlspecialchars($province);

		$license = trim($_POST['license']);
		$license = strip_tags($license);
		$license = htmlspecialchars($license);

		//Referral setup
		$rfName = trim($_POST['rfName']);
		$rfName = strip_tags($rfName);
		$rfName = htmlspecialchars($rfName);

		$rdob = trim($_POST['rdob']);
		$rdob = strip_tags($rdob);
		$rdob = htmlspecialchars($rdob);

		// basic name validation
		if (empty($name)) {
			$error = true;
			$nameError = "Please enter your desired username.";
		} else if (strlen($name) < 3) {
			$error = true;
			$nameError = "Username must have at least 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$nameError = "Names must contain alphabets and space.";
		}

		// basic FIRST name validation
		if (empty($fName)) {
			$error = true;
			$FnameError = "Please enter your first name.";
		} else if (strlen($fName) < 3) {
			$error = true;
			$FnameError = "Names must have at least 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$fName)) {
			$error = true;
			$FnameError = "Names must contain alphabets and space.";
		}

		// basic LAST name validation
		if (empty($lName)) {
			$error = true;
			$LnameError = "Please enter your last name.";
		} else if (strlen($lName) < 3) {
			$error = true;
			$LnameError = "Names must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$lName)) {
			$error = true;
			$LnameError = "Names must contain alphabets and space.";
		}

		// basic date validation
		if (empty($dob)) {
			$error = true;
			$dobError = "Please enter your date of birth.";
		} else if (strlen($dob) > 8 || strlen($dob) < 8) {
			$error = true;
			$dobError = "date must be exactly 8 numbers long (year/month/day).";
		} //else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			//$error = true;
		//	$nameError = "Names must contain alphabets and space.";
		//}

		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT Email FROM account WHERE Email='$email'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$passError = "Please enter password.";
		} else if(strlen($pass) < 6) {
			$error = true;
			$passError = "Password must have at least 6 characters.";
		}

		// password encrypt using SHA256();
		$password = hash('sha256', $pass);

		// ADRESS STUFF VALIDATION HERE
		if (empty($address1)) {
			$error = true;
			$Add1Error = "Please enter the first line of your address.";
		} else if (strlen($address1) < 3) {
			$error = true;
			$Add1Error = "first line must have at least 3 characters.";
		}

		if (empty($city)) {
			$error = true;
			$cityError = "Please enter your city's name.";
		}

		if (empty($postal)) {
			$error = true;
			$postalError = "Please enter your postal code.";
		//} else if (strlen($postal) != 7) {
			//$error = true;
			//$postalError = "Postal code must be exactly 6 characters (No spaces)";
		}else if (!preg_match("/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/",$postal)) {
			$error = true;
			$postalError = "INVALID POSTAL CODE.";
		}

		if (empty($province)) {
			$error = true;
			$provinceError = "Please enter your province code (2 letters).";
		} else if (strlen($province) != 2) {
			$error = true;
			$provinceError = "province codes must be exactly 2 characters.";
		} else if (!preg_match("/^[A-Z]+$/",$province)) {
			$error = true;
			$provinceError = "province code must be letters only.";
		}

		if (empty($license)) {
			$error = true;
			$licenseError = "Please enter your Driver's License Code";
		} else if (strlen($license) < 8) {
			$error = true;
			$licenseError = "Driver's License codes must be more than 8 characters long.";
		}
		//Referral system
		if (empty($rfName)) {
			$error = true;
			$rFnameError = "Please enter the first name of the user who referred you.";
		} else if (strlen($rfName) < 3) {
			$error = true;
			$rFnameError = "Referral Names must have at least 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$rfName)) {
			$error = true;
			$rFnameError = "Referral Names must contain alphabets and space.";
		}

		if (empty($rdob)) {
			$error = true;
			$rdobError = "Please enter the date of birth of the user who referred you.";
		} else if (strlen($rdob) > 8 || strlen($rdob) < 8) {
			$error = true;
			$rdobError = "Referral date must be exactly 8 numbers long (year/month/day).";
		}
		// if there's no error, continue to signup
		if( !$error ) {

			$referCheck = sprintf("SELECT * FROM member WHERE `firstName` = '%s' AND `Birthday` = '%s'",
					mysql_real_escape_string($rfName),
					mysql_real_escape_string($rdob));

			$referQuery = mysql_query($referCheck);

			if(mysql_num_rows($referQuery) < 1 || !$referQuery)
			{
				$referCount = 0;
				$errTyp = "danger";
				$errMSG = "THE PERSON YOU ENTERED AS YOUR REFERRAL IS NOT IN THE SYSTEM";
				//echo $errMSG;
			}else{
				$referCount = mysql_num_rows($referQuery);

				//die(mysql_errno($conn) . ": " . mysql_error($conn));

				$query1 = sprintf("INSERT INTO member(firstName, lastName, Birthday, Role, isAdmin) VALUES('%s','%s', '%s', 'Driver', false)",
						mysql_real_escape_string($fName),
						mysql_real_escape_string($lName),
						mysql_real_escape_string($dob)
					);

				$res1 = mysql_query($query1);
				$storeMemberID = mysql_insert_id();

				$query2 = sprintf("INSERT INTO memberDetails(id, address1, address2, city, postalCode, province, license) VALUES('%s','%s', '%s', '%s', '%s', '%s', '%s')",
						mysql_real_escape_string($storeMemberID),
						mysql_real_escape_string($address1),
						mysql_real_escape_string($address2),
						mysql_real_escape_string($city),
						mysql_real_escape_string($postal),
						mysql_real_escape_string($province),
						mysql_real_escape_string($license)
					);

				$query3 = sprintf("INSERT INTO account(MID, Username,Email,Password, Balance) VALUES('%s','%s','%s','%s', 10)",
						mysql_real_escape_string($storeMemberID),
						mysql_real_escape_string($name),
						mysql_real_escape_string($email),
						mysql_real_escape_string($password)
					);
				$res2 = mysql_query($query2);

				//echo "RANDOM STRING!!!  = ";
				//die(mysql_errno($conn) . ": " . mysql_error($conn));

				$res3 = mysql_query($query3);

				//die($res2);
				if ($res1 && $res2 &&$res3) {
									$errTyp = "success";
									$errMSG = "Successfully registered, you may login now";
									//echo $errMSG;
									unset($name);
									unset($fName);
									unset($lName);
									unset($dob);
									unset($email);
									unset($pass);
									unset($address1);
									unset($address2);
									unset($city);
									unset($postal);
									unset($province);
									unset($rfName);
									unset($rdob);
									unset($license);
				} else {
					$errTyp = "danger";
					$errMSG = "Something went wrong, try again later...";
					//echo $errMSG;
					//header('Location:index.php');
				}
			}



		}

 //action="action_register.php" autocomplete="off"> -->
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
    <form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">


    	<div class="col-md-12">

        	<div class="form-group">
            	<h2 class="">Sign Up.</h2>
            </div>

        	<div class="form-group">
            	<hr />
            </div>

            <?php
			if ( isset($errMSG) ) {

				?>
				<div class="form-group">
            	<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>

            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            	<input type="text" name="name" class="form-control" placeholder="Enter desired UserName" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>

<!-- -->
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
	<input type="text" name="fName" class="form-control" placeholder="Enter First Name" maxlength="50" value="<?php echo $fName ?>" />
		</div>
		<span class="text-danger"><?php echo $FnameError; ?></span>
</div>


<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
	<input type="text" name="lName" class="form-control" placeholder="Enter Last Name" maxlength="50" value="<?php echo $lName ?>" />
		</div>
		<span class="text-danger"><?php echo $LnameError; ?></span>
</div>

<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
	<input id="dateOfBirth" type="text" name="dob" class="form-control" placeholder="Enter date of birth here" maxlength="50" value="<?php echo $dob ?>" />
		</div>
		<span class="text-danger"><?php echo $dobError; ?></span>
</div>

            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>

            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input id="myPassword" type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="form-group">
            	<hr />
            </div>

						<!-- ADDRESS STUFF! -->

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="address1" class="form-control" placeholder="Enter First line of address here" maxlength="50" value="<?php echo $address1 ?>" />
								</div>
								<span class="text-danger"><?php echo $Add1Error; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="address2" class="form-control" placeholder="Enter Second line of address here" maxlength="50" value="<?php echo $address2 ?>" />
								</div>
								<span class="text-danger"><?php echo $Add2Error; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="city" class="form-control" placeholder="Enter City here" maxlength="50" value="<?php echo $city ?>" />
								</div>
								<span class="text-danger"><?php echo $cityError; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input id="PostCode" type="text" name="postal" class="form-control" placeholder="Enter 6 Digit Postal code here (no spaces)" maxlength="50" value="<?php echo $postal ?>" />
								</div>
								<span class="text-danger"><?php echo $postalError; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
								<select name="province">
								  <option value="" <?php $province = '' ?> >Select province</option>
								  <option value="NL" <?php $province = 'NL' ?> >Newfoundland and Labrador</option>
								  <option value="PE" <?php $province = 'PE' ?> >Prince Edward Island</option>
									<option value="NS" <?php $province = 'NS' ?> >Nova Scotia </option>
								  <option value="NB" <?php $province = 'NB' ?> >New Brunswick</option>
									<option value="QC" <?php $province = 'QC' ?> >Quebec</option>
								  <option value="ON" <?php $province = 'ON' ?> >Ontario</option>
									<option value="MB" <?php $province = 'MB' ?> >Manitoba</option>
								  <option value="SK" <?php $province = 'SK' ?> >Saskatchewan</option>
									<option value="AB" <?php $province = 'AB' ?> >Alberta</option>
								  <option value="BV" <?php $province = 'BV' ?> >British Columbia</option>
									<option value="YT" <?php $province = 'YT' ?> >Yukon</option>
								  <option value="NT" <?php $province = 'NT' ?> >Northwest Territories</option>
									<option value="NU" <?php $province = 'NU' ?> >Nunavut</option>
								</select>
							<!-- <input type="text" name="province" class="form-control" placeholder="Enter province here" maxlength="50" value="<?php //echo $province ?>" /> -->
								</div>
								<span class="text-danger"><?php echo $provinceError; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input id="licenseCode" type="text" name="license" class="form-control" placeholder="Enter your Driver's License Code here" maxlength="50" value="<?php echo $license ?>" />
								</div>
								<span class="text-danger"><?php echo $licenseError; ?></span>
						</div>

						<div class="form-group">
						<hr />
						</div>

						<!-- REFERRAL STUFF HERE! -->
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="rfName" class="form-control" placeholder="Enter the first name of the person who referred you" maxlength="50" value="<?php echo $rfName ?>" />
								</div>
								<span class="text-danger"><?php echo $rFnameError; ?></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input id="RdateOfBirth" type="text" name="rdob" class="form-control" placeholder="Enter the date of birth of the person who referred you here" maxlength="50" value="<?php echo $rdob ?>" />
								</div>
								<span class="text-danger"><?php echo $rdobError; ?></span>
						</div>

						            <div class="form-group">
						            	<hr />
						            </div>

						<!-- Referral system!-->

            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            </div>

            <div class="form-group">
            	<hr />
            </div>

            <div class="form-group">
            	<a href="login.php">Sign in Here...</a>
            </div>

        </div>

    </form>
    </div>

</div>

<script src="assets/js/jquery.js" type="text/javascript"></script>
<script src="assets/js/jquery.maskedinput.js" type="text/javascript"></script>

<script type="text/javascript">
 jQuery(function($){
	       $.mask.definitions['~']='[+-]';
   $("#dateOfBirth").mask("99999999",{placeholder:"yyyymmdd"});
	 $("#RdateOfBirth").mask("99999999",{placeholder:"yyyymmdd"});
	 $("#PostCode").mask("a9a9a9",{placeholder:"x1x1x1"});
	 $("#licenseCode").mask("a9999-999999-99",{placeholder:"a1111-111111-11"});
}); </script>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/strength.js"></script>

<script>



//PASS STRENGTH CHECKER
$(document).ready(function($) {

$('#myPassword').strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'Show Password',
            strengthButtonTextToggle: 'Hide Password'
        });

});

</script>

</body>
</html>
<?php ob_end_flush(); ?>
