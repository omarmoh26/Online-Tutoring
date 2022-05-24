<link rel="stylesheet" type="text/css" href ="DeleteAccount.css">

<?php
	include "AuditorMenu.php";
	echo "<n class='n'>".$_SESSION['Name']."</n>";
	echo "<br> </n> <n2 class='n2'> are you sure you want to delete this account?</n2>";
?>

	<div class="wrapper fadeInDown">
		<form action="" method="post">
			<input class="n3" type="submit" value="DELETE" name="yes">
			<input class="n4" type="submit" value="Cancel" name="no">
		</form>
	</div>	

<?php
	if(isset($_POST['yes'])){
		try{
			if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
				throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
			}
		}
		catch (customException $e) {
			echo $e->errorMessage();
			}
		$sql="delete from user where UserID =".$_SESSION['ID'];
		$result=mysqli_query($conn,$sql);
		if($result)
		{
			session_destroy();
			echo "<script>window.location.href = '../Home.php';</script>";
		}
		else
		{
			trigger_error("<h1 style='color:red;'>Cannont delete this account</h1>",E_USER_WARNING);
		}
	}
	if(isset($_POST['no'])){
		echo "<script>window.location.href = 'AuditorHome.php';</script>";
	}
?>