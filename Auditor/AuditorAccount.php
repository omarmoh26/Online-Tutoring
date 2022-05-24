<html>
<?php
include "AuditorMenu.php";
?>
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  font-size: 20px;
}

li a {
  display: block;
  color: darkred;
  padding: 14px 16px;
  font-family: 'Oswald', sans-serif;
}

li a:hover {
	background-color: gold;
	color: navy;
}

    
</style>

<ul>
	<li><a href='EditNameAuditor.php'><i class="fa fa-pencil-square-o" style="font-size:36px"></i> Edit Name </a></li>
	<li><a href='EditPicAuditor.php'><i class="fa fa-photo" style="font-size:36px"></i > Edit Picture </a></li>
	<li><a href='EditPassAuditor.php'><i class="fa fa-lock" style="font-size:36px"></i> Edit Password </a></li>
	<li><a href='DeleteAccount.php'> <i class='fas fa-trash-alt' style='font-size:36px'></i> Delete </a></li>
	<li><a href='../SignOut.php'> <i class="fa fa-sign-out" style="font-size:36px"></i> SignOut </a> </li>
</ul>
</html>