<html>
<?php
include "AdminMenu.php";
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
	<li><a href='LearnersView.php'> Learners </a></li>
	<li><a href='TutorsView.php'> Tutors </a></li>
	<li><a href='AuditorsView.php'> Auditor </a></li>
  <li><a href='OtherAdmins.php'> Admins</a></li>
</html>