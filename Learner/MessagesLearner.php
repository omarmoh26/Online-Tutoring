<link rel="stylesheet" type="text/css" href ="../Admin/ContactUsMessages.css">

<?php
include "../links.html";
include "LearnerMenu.php";
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}

 
?>

<form class="form-inline" method = "POST" action = "">
    <input type="text" name = "name" placeholder="Search" class="form-control">
    <input type="submit" value='Search' name='search' class="btn btn-default">
</form>
<?php
if(isset($_POST['search'])) {
    $search=$_POST['name'];
    $searchUser = "SELECT * FROM user WHERE Name = '$search' and Type='learner' and UserID!=".$_SESSION['ID'];
    $searchUserResult = mysqli_query($conn,$searchUser);

    while($searchUserRow = mysqli_fetch_array($searchUserResult))
    {  ?>
        <div class="nav">
        <img src = "../images/<?=$searchUserRow['Image']?>" class="img-circle" width='80' height='80'/>
        <n><br><?=$searchUserRow['Name']?>
        <a  style="text-decoration:none; color:brown;" href="MessageLearner.php?receiver=<?=$searchUserRow['UserID']?>"><i class='fas fa-comment-alt' style='font-size:24px'></i></a></n>
        </div>
<?php }
}
?>
<div>
<?php
$lastMessage = "SELECT DISTINCT sent_by FROM messages WHERE received_by = ".$_SESSION['ID'];
$lastMessageResult = mysqli_query($conn,$lastMessage) or trigger_error("<h1 style='color:red;>".mysqli_error($conn)."</h1>",E_USER_WARNING);
if(mysqli_num_rows($lastMessageResult) > 0) {
    while($lastMessageRow = mysqli_fetch_array($lastMessageResult)) {
        $sent_by = $lastMessageRow['sent_by'];
        $getSender = "SELECT * FROM user WHERE user.UserID = '$sent_by'";
        $getSenderResult = mysqli_query($conn,$getSender) or trigger_error("<h1 style='color:red;>".mysqli_error($conn)."</h1>",E_USER_WARNING);
        $getSenderRow = mysqli_fetch_array($getSenderResult);
        ?>
        <div class="nav">
        <img src = "../images/<?=$getSenderRow['Image']?>" class="img-circle"  width='80' height='80'/> 
        <n><br><?=$getSenderRow['Name'];?>
        <a style="text-decoration:none; color:brown;" href="MessageLearner.php?receiver=<?=$sent_by?>"><i class='fas fa-comment-alt' style='font-size:24px'></i></a></n>
        </div><br>
<?php }
}
?>
</div>

