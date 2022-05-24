<link rel="stylesheet" type="text/css" href ="Logincss.css" >
<?php 
session_start();
include "Menu.php";

function customError($errno,$errstr) {
	echo "$errstr<br>";
}
set_error_handler("customError");

class customException extends Exception {
	public function errorMessage() {
		$errorMsg = $this->getMessage();
		return $errorMsg;
	}
}
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}

if(isset($_POST['Submit'])){ 
		$e=$_POST['Email'];
		$p=$_POST['Password'];
	
	$sanitizedEmail=filter_var($e,FILTER_SANITIZE_EMAIL);
	$sanitizedPass=filter_var($p,FILTER_SANITIZE_STRING);
	
	$sql="select * from user where Email='$sanitizedEmail' and Password='$sanitizedPass'";
	$result = mysqli_query($conn,$sql);	

	if($row=mysqli_fetch_array($result))
	{
		$_SESSION["ID"]=$row[0];
		$_SESSION['Name']=$row["Name"];
		$_SESSION['Email']=$row["Email"];
		$_SESSION['Password']=$row["Password"];
		$_SESSION['usertype']=$row['Type'];
		$_SESSION["Image"]=$row["Image"];

		if($_SESSION['usertype']=="learner"){
			header("Location:Learner/LearnerHome.php");
		}
		else if($_SESSION['usertype']=="administrator"){
			header("Location:Admin/AdminHome.php");
		}
		else if($_SESSION['usertype']=="tutor"){
			header("Location:Tutor/TutorHome.php");
		}
		else if($_SESSION['usertype']=="auditor"){
			header("Location:Auditor/AuditorHome.php");
		}
		else
			header("Location:home.php");
	}
	else	
	{
		trigger_error("<h1 style='color:red;'>Incorrect Email or Password</h1>",E_USER_WARNING);
	}
}	

?>

<div class="wrapper ">
	<div id="formContent">
		<h2 id="sign" class="active"> Log In </h2>

		<form action="" method="post" onsubmit='return validate(this)'>
			<input type="email" id="login"  name="Email" placeholder="email">
			<input type="Password" id="password" name="Password" placeholder="password">
			<input type="submit" name="Submit" value="Log In">
			<input type="reset" value="reset">
		</form>

	</div>
</div>
<head>

	<script>
		function validateEmail(field){
			if(field=='')
			return 'No Email was entered \n';
			else
			return '';
		}
		function validatePassword(field){
			if(field=='')
			return 'No Password was entered';
			else
			return '';
		}
		function validate(form){
			fail='';
			fail+=validateEmail(form.Email.value);
			fail+=validatePassword(form.Password.value);
			if(fail=='')
			return true;
			else{
				alert(fail);
				return false;
			}
		}
		</script>
</head>