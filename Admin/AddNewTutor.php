<head><link rel="stylesheet" type="text/css" href ="AddNewAdmin.css"></head>
<?php
include "AdminHome.php";
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}

if(isset($_POST['Submit'])){
	
	if($_FILES['myfile']['size']!=0){
	$dir='../images/';
	$fileName=$_FILES['myfile']['name'];
	move_uploaded_file($_FILES['myfile']['tmp_name'],$dir.$fileName);
	}
	else{
		$fileName="";
	}
		
		$n=$_POST['Name'];
		$e=$_POST['Email'];
		$p=$_POST['confirm_password'];
		
		$sanitizedName=filter_var($n,FILTER_SANITIZE_STRING);
		$sanitizedEmail=filter_var($e,FILTER_SANITIZE_EMAIL);
		$sanitizedPass=filter_var($p,FILTER_SANITIZE_STRING);
		if (filter_var($sanitizedEmail,FILTER_VALIDATE_EMAIL)){
		$sql="INSERT INTO user (Name,Email,Password,Type,Image)
				VALUES ('$sanitizedName','$sanitizedEmail','$sanitizedPass','tutor','$fileName')";
		$result=mysqli_query($conn,$sql);
		if($result)	
		{
			header("Location:TutorsView.php");
		}
		else
		{
			trigger_error("<h1 style='color:red;'>Unable to Add new Tutor</h1>",E_USER_WARNING);
		}
	}
	else{
		trigger_error("<h1 style='color:red;'>Please enter your Email correctly</h1>",E_USER_WARNING);
	}
}
?>




<div class="wrapper">
  <div id="formContent">
		<h2 id="sign" class="active">Add New Tutor</h2>
		<form action="" method="post" enctype='multipart/form-data' onsubmit='return validate(this)'>
		<input type="text" name="Name" placeholder="Name"><br> 
		
		<input type="email" name="Email" placeholder="Email"/> <br>
		
		<input name="password" id="password" type="password" placeholder="Password" onkeyup='check();' />
		<br>
		<br><input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"  onkeyup='check();' /> 
		<br><span id='message'></span>
		

		<br><span id = "verifymessage" style="color:red"> </span> <br>
		<span> choose picture</span>
		<input type='file' name='myfile' id='file' onchange='return fileValidation()'><br>

		<input type="submit" value="Submit" name="Submit">
		</form>
	</div>
</div>		
<head>
	<script>
		function validateName(field){
			if(field=='')
				return 'No Name was entered \n';
			else
				return '';
		}
		function validateEmail(field){
			if(field=='')
				return 'No Email was entered \n';
			else
				return '';
		}
		function validatenewPass(field){
			if(field=='')
				return 'Enter password \n';
			else
				return '';
		}
		function validateconfirmnewPass(field){
			if(field=='')
				return 'Enter Confirm password \n';
			else
				return '';
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
		
		function validate(form){
			fail='';
			fail+=validateName(form.Name.value);
			fail+=validateEmail(form.Email.value);
			fail+=validatenewPass(form.password.value);
			fail+=validateconfirmnewPass(form.confirm_password.value);
			if(fail==''){
				pw=form.confirm_password.value;   
				if(pw.length < 8) {  
					 document.getElementById("verifymessage").innerHTML = "*Password length must be atleast 8 characters*";  
					 return false;  
				 }   
				if(pw.length > 15) {  
					 document.getElementById("verifymessage").innerHTML = "*Password length must not exceed 15 characters*";  
					 return false;  
				} 
				else {  
					 return true;
				}  
					
			}
				
			else{
				alert(fail);
				return false;
			}
		}
		function fileValidation() {
            var fileInput = 
                document.getElementById('file');
              
            var filePath = fileInput.value;
            var allowedExtensions = 
                    /(\.jpg|\.jpeg|\.png|\.gif)$/i;
              
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            } 
        }
	</script>
</head>