<link rel="stylesheet" type="text/css" href ="EditPassAdmin.css">
<html>
<?php 
include "AdminMenu.php";
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}

if(isset($_POST['submit'])){
	$i=$_SESSION['ID'];
	
	$oldp=$_POST['oldpass'];
	$newp=$_POST['confirm_password'];
	
	$sanitizedoldp=filter_var($oldp,FILTER_SANITIZE_STRING);
	$sanitizednewp=filter_var($newp,FILTER_SANITIZE_STRING);
	$type=$_SESSION['usertype'];
	
	if($sanitizedoldp==$_SESSION['Password']){
		if($sanitizednewp!=$sanitizedoldp){
			$sql="update user set Password='$sanitizednewp' where UserID='$i'";
			$result=mysqli_query($conn,$sql);
			
			if(!$result){
				trigger_error("<h1 style='color:red;'>Unable to update your Password</h1>",E_USER_WARNING);

			}
			else{
				$_SESSION["Password"]=$sanitizednewp;
				header("Location:AdminHome.php");
			}
		}
		else{
			trigger_error("<h1 style='color:red;'>You Entered the same old Password!</h1>",E_USER_WARNING);
		}
	}
	else{
		trigger_error("<h1 style='color:red;'>You Entered wrong Old Password</h1>",E_USER_WARNING);
	}
	
}

?>

<div class="wrapper ">
	<div id="formContent">
		<form action='' method='POST'  onsubmit='return validate(this)'>

		<input type= 'Password'  name= 'oldpass'  placeholder='Old Password' >

		<input name="password" id="password" type="password" placeholder='New Password' onkeyup='check();' />

		<input type="password" name="confirm_password" id="confirm_password" placeholder='Confirm Password' onkeyup='check();' /> 

		<br><span id='message'></span>

		<br><span id = "verifymessage" style="color:red"> </span> <br>

		<input type= 'submit'  name= 'submit'  value= 'Submit' >

		<input type="button" value="Cancel" onclick="cancel()"></input>

		</form>
	</div>
</div>	
<head>
	<script>
		function cancel() {
            window.location.href = "AdminHome.php";
        }
		var check = function() {
			if (document.getElementById('password').value ==
				document.getElementById('confirm_password').value) {
				document.getElementById('message').style.color = 'green';
				document.getElementById('message').innerHTML = 'matching';
			} 
			else {
				document.getElementById('message').style.color = 'red';
				document.getElementById('message').innerHTML = 'not matching';
			}
		}
		function validateoldPass(field){
			if(field=='')
				return 'Enter old password \n';
			else
				return '';
		}
		function validatenewPass(field){
			if(field=='')
				return 'Enter new password \n';
			else
				return '';
		}function validateconfirmnewPass(field){
			if(field=='')
				return 'Enter Confirm password \n';
			else
				return '';
		}
		
		function validate(form){
			fail='';
			fail+=validateoldPass(form.oldpass.value);
			fail+=validatenewPass(form.password.value);
			fail+=validateconfirmnewPass(form.confirm_password.value);
			if(fail==''){
				pw=form.confirm_password.value;   
				if(pw.length < 8) {  
					 document.getElementById("verifymessage").innerHTML = "**Password length must be atleast 8 characters";  
					 return false;  
				 }  
				if(pw.length > 15) {  
					 document.getElementById("verifymessage").innerHTML = "**Password length must not exceed 15 characters";  
					 return false;  
				} 
				else {  
					 alert("Password Changed Successfully"); 
					 return true;
				}  
					
			}
				
			else{
				alert(fail);
				return false;
			}
			
		}
	</script>
</head>
</html>