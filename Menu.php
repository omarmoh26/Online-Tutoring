<html>
	<?php include "links.html"; ?>
<head>
	<style>
		
	body {
		background-image: url('images/banner1.png');
		background-size: 100% 150%;
		background-repeat: no-repeat;
		height: 100%;
		width: 100%;
		position: relative;
		overflow: scroll;
		overflow-x: hidden;
	}

	.topnav {
		font-size: 20px; 
		padding: 15px 0px;
		align-items:right;
		
	}
	
	ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
		overflow: hidden;
		float:right;

	}
	li {
		
		float: left;
	}
	li a {
		display: block;
		color: darkred;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
		font-family: 'Oswald', sans-serif;
		float:top;

	}
	
	</style>
</head>
	
	<body>		
		<div class="topnav">
			<?php
			
				if(!empty($_SESSION['ID'])) 
				{
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
				else{	
					echo "<i><img src=images/EGLearn.png alt='Italian Trulli' width='329.5' height='78.39'></i>";
					echo"<ul>";
					echo"<li><a href='home.php' > <i class='fa fa-home' style='font-size:36px' ></i> Home </a> </li>";
					echo"<li><a href='Login.php'> <i class='fa fa-sign-in' style='font-size:36px' ></i></i> Login </a> </li>";
					echo"<li><a href='SignUp.php'> <i class='fa fa-user-plus' style='font-size:36px' ></i> SignUp </a> </li>";
					echo "</ul>";
				}
				?>
	
		<br><br>
		</div>
		
	</body>
</html>