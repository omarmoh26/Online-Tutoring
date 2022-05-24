<link rel="stylesheet" type="text/css" href ="EditPicAuditor.css">
<?php 
include "AuditorMenu.php";
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
	
	if(!empty($_FILES['myfile'])){
	$dir='../images/';
	$fileName=$_FILES['myfile']['name'];
	move_uploaded_file($_FILES['myfile']['tmp_name'],$dir.$fileName);
	}
	else{
		$fileName=$_SESSION["Image"];
	}
	$type=$_SESSION['usertype'];
	$sql="update user set Image='$fileName' where UserID='$i'";
		$result=mysqli_query($conn,$sql);
		if(!$result){
			trigger_error("<h1 style='color:red;'>Unable to update your picture</h1>",E_USER_WARNING);
		}
		else{
			$_SESSION["Image"]=$fileName;
			header("Location:AuditorHome.php");
		}
}

?>
<div class="wrapper ">
	<div id="formContent">
		<form action='' method='POST' enctype="multipart/form-data" onsubmit='return validate(this)'>
		<input type='file' name='myfile' id="file" onchange="return fileValidation()"><br>
		<input type= 'submit'  name= 'submit'  value= 'Submit' ><br>
		<input type="button" value="Cancel" onclick="cancel()"></input>
		</form>
	</div>
</div>	
<head>
	<script>
		function cancel() {
            window.location.href = "AuditorHome.php";
        }
		function validatePic(field){
			if(field=='')
				return 'Choose a new Picture \n';
			else
				return '';
		}
		function validate(form){
			fail='';
			fail+=validatePic(form.myfile.value);
			if(fail=='')
				return true;
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
