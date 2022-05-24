<link rel="stylesheet" type="text/css" href ="../Admin/ContactUsMessage.css">

<?php
include "LearnerMenu.php";
include "../links.html";

try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}

function getReceiver($conn,$ID){
    $getReceiver = "SELECT * FROM user WHERE user.UserID = '$ID'  ";
    $getReceiverResult = mysqli_query($conn,$getReceiver) or trigger_error("<h1 style='color:red;>".mysqli_error($conn)."</h1>",E_USER_WARNING);
    $getReceiverRow = mysqli_fetch_array($getReceiverResult);
    return $getReceiverRow;
}

$receiver = $_GET['receiver'];

$getReceiverRow=getReceiver($conn,$receiver);
?>
<div style="font-size:20px;">
<img src="../images/<?=$getReceiverRow['Image']?>" class="img-circle"  width='80' height='80'/>
<?=$getReceiverRow['Name']?></div>
<table class="table table-striped">

<?php
if(isset($_POST['submit'])) {

  $createdAt = date("Y-m-d h:i:sa");
  $sent_by = $_POST['sent_by'];
  $receiver = $_POST['received_by'];
  $message = filter_var($_POST['message'],FILTER_SANITIZE_STRING);

  $sendMessage = "INSERT INTO messages(sent_by,received_by,message,createdAt) VALUES('$sent_by','$receiver','$message','$createdAt')";
  mysqli_query($conn,$sendMessage) or trigger_error("<h1 style='color:red;>Can't Send Your Message</h1>",E_USER_WARNING);
}

$getMessage = "SELECT  messages.* ,user.Name FROM messages INNER JOIN user on sent_by=user.UserID  WHERE sent_by = '$receiver' AND received_by = ".$_SESSION['ID']." OR sent_by = ".$_SESSION['ID']." AND received_by = '$receiver' ORDER BY createdAt asc";
$seenreciept="UPDATE messages SET seen='yes' WHERE received_by=".$_SESSION['ID']." and sent_by= '$receiver'";
$result = mysqli_query($conn,$seenreciept);	
$getMessageResult = mysqli_query($conn,$getMessage) or trigger_error("<h1 style='color:red;>Canno't show Messages</h1>",E_USER_WARNING);
if(mysqli_num_rows($getMessageResult) > 0) {
    while($getMessageRow = mysqli_fetch_array($getMessageResult)) { ?>
    <tr><div style = "margin: 10;">
    <td>    <h4 style = "color: black;display:inline"><?=$getMessageRow['Name']?></h4></td>
    <td>    <p class="text-center" style = "display:inline"><?=$getMessageRow['message']?></p></td>
        </div>
        </tr>
<?php } 
} 
else { 
    echo "<tr><td><p>No messages yet! Say 'Hi'</p></td></tr>";
}
?>
</table>
<form class="form-inline" action="" method = "POST">
    <input type="hidden" name = "sent_by" value = "<?=$_SESSION['ID']?>"/>
    <input type="hidden" name = "received_by" value = "<?=$receiver?>"/>
    <textarea name = "message" rows="4" cols="100" maxlength="100" size="20" placeholder = "Type your message here" required></textarea>
    <input type = "submit" value='send' name='submit' class="btn btn-default">
</form>
<?php

?>
