
<?php
include "../links.html";
include "AuditorMenu.php";
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}

 
?>
<div>
<?php
$lastMessage = "SELECT DISTINCT sent_by FROM contactus WHERE received_by = '0'";
$lastMessageResult = mysqli_query($conn,$lastMessage) or trigger_error("<h1 style='color:red;>".mysqli_error($conn)."</h1>",E_USER_WARNING);
if(mysqli_num_rows($lastMessageResult) > 0) {
    while($lastMessageRow = mysqli_fetch_array($lastMessageResult)) {
        $sent_by = $lastMessageRow['sent_by'];
        $getSender = "SELECT * FROM user WHERE user.UserID = '$sent_by'";
        $getSenderResult = mysqli_query($conn,$getSender) or trigger_error("<h1 style='color:red;>".mysqli_error($conn)."</h1>",E_USER_WARNING);
        $getSenderRow = mysqli_fetch_array($getSenderResult);
        ?>
        <div>
        <img src = "../images/<?=$getSenderRow['Image']?>" class="img-circle" width = "40"/> 
        <?=$getSenderRow['Name'];?>
        <a style="text-decoration:none; color:brown;" href="ContactUsMessage.php?receiver=<?=$sent_by?>"><i class="fa fa-eye" style="font-size:24px"></i></a>
        </div><br>
<?php }
} 
else {
    echo "No conversations yet!";
}
?>
</div>

