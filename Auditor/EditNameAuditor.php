<link rel="stylesheet" type="text/css" href ="EditNameAuditor.css">
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
	$n=$_POST['name'];
	if(!empty($n)){
	$sanitizedName=filter_var($n,FILTER_SANITIZE_STRING);
	$type=$_SESSION['usertype'];
	
			$sql="update user set Name='$sanitizedName' where UserID='$i'";
			$result=mysqli_query($conn,$sql);
			
			if(!$result){
				trigger_error("<h1 style='color:red;'>Unable to update your name</h1>",E_USER_WARNING);
			}
			else{
				$_SESSION["Name"]=$sanitizedName;
				header("Location:AuditorHome.php");
			}
	}
	
}

?>

<div class="wrapper">
    <div id="formContent">
		<form action='' method='POST' onsubmit='return validate(this)'>
		<input type= 'text'  name= 'name' placeholder="Name"  value= <?php echo $_SESSION['Name']?> >
		<input type= 'submit'  name= 'submit'  value= 'Submit' >
		<input type="button" value="Cancel" onclick="cancel()"></input>
		</form>
	</div>
</div>
<head>
	<script>
		function cancel() {
            window.location.href = "AuditorHome.php";
        }
		function validatename(field){
			if(field=='')
				return 'Enter a name \n';
			else
				return '';
		}
		function validate(form){
			fail='';
			fail+=validatename(form.name.value);
			if(fail=='')
				return true;
			else{
				alert(fail);
				return false;
			}
		}
	</script>
</head>