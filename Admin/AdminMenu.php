<html>
	<?php 
	include "../links.html"; 
	session_start();
	function customError($errno, $errstr) {
		echo "$errstr<br>";
		die();
	}
	set_error_handler("customError");
	
	class customException extends Exception {
		public function errorMessage() {
			$errorMsg = $this->getMessage();
			return $errorMsg;
		}
	}
	?>
<head>
	<style>
		
	body {
		background: linear-gradient(132deg, #0892d0,#fc6c85 , #6050dc);
		background-size: 400% 400%;
		animation: Gradient 15s ease infinite;
		position: relative;
		height: 100%;
		width: 100%;
		overflow: scroll;
		overflow-x: hidden;
		padding:0;
		margin:0px;
	}
	@keyframes Gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
	.topnav ul{
		list-style-type: none;
		color: blue;
		margin: 0;
  		padding: 0;
		overflow: hidden;
		font-size: 25px;
	}
	.topnav ul li {
		float: left;
	}
	.topnav li a {
		display: inline-block;
		color: darkred;
		text-align: center;
		padding: 14px 16px;
		font-family: 'Oswald', sans-serif;
		text-decoration: none;
	}
	.topnav i{
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
	.topnav n{
		
	   width:120px;
	   font-size: 20px;
	   font-weight: 600;
	   position:fixed;
	   right:0;
	   top:10;
    }
	.topnav n1{
		
		width:120px;
		font-size: 20px;
		font-weight: 600;
		position:fixed;
		top:2;
		right:55;
	 }
	.circular
	{
		border-radius: 50%;
	}
	
	.topnav li a:hover{
		background-color: gold;
		color: navy;
	}
	
	</style>
</head>
	
	<body>		
		<div class="topnav">
			<?php
				if(!empty($_SESSION['ID'])) 
				{
					echo "<i><img src=../images/EGLearn.png alt='Italian Trulli' width='329.5' height='78.39'></i>";
					echo "<n><b>".$_SESSION['Name']."</b></n>";
					echo "<n1><img class='circular' src=../images/".$_SESSION["Image"]." alt='Italian Trulli' width='50' height='50'><br></n1>";
                    echo"<ul>";
					echo"<li><a href='AdminHome.php'><i class='fa fa-home' style='font-size:36px' ></i> Home </a></li>";
					echo"<li><a href='AdminCourses.php'><i class='fas fa-laptop-code' style='font-size:36px'></i>  Courses </a> </li>";
					echo"<li><a href='AdminOrders.php'><i class='fas fa-box' style='font-size:36px'></i> Orders </a> </li>";
					echo"<li><a href='AdminUsers.php'><i class='fa fa-users' style='font-size:36px'></i> Users </a> </li>";
					echo"<li><a href='ViewMessages.php'><i class='fas fa-comments' style='font-size:36px'></i>Learners' Chat </a> </li>";
					echo"<li><a href='ContactUsMessages.php'> <i class='fa fa-envelope' style='font-size:36px'></i> Contact Us </a> </li>";
					echo"<li><a href='AdminAccount.php'> <i class='fas fa-user-circle' style='font-size:36px'> </i>Account </a> </li>";
                    echo "</ul>";
				}
				?>
	
		<br><br>
		</div>
	</body>
</html>