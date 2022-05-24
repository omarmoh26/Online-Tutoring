<link rel="stylesheet" type="text/css" href ="ContactUsMessage.css">
<?php
include "../links.html";
include "AdminMenu.php";
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}
?>
<table class="table table-striped">
<tr><div style = "margin: 10;">
    <th>    <h4 style = "color: black;display:inline;">Name</h4></th>
    <th>    <p class="text-center" style = "display:inline;">Message</p></th>
        </div>
    </tr>
<?php

$id = $_GET['id'];
$getMessage = "SELECT  messages.* ,user.Name FROM messages INNER JOIN user on sent_by=user.UserID  WHERE received_by = '$id' OR sent_by = '$id' or sent_by = '$id'  ORDER BY createdAt asc";
$getMessageResult = mysqli_query($conn,$getMessage) or trigger_error("<h1 style='color:red;>Canno't show Messages</h1>",E_USER_WARNING);
if(mysqli_num_rows($getMessageResult) > 0) {
    while($getMessageRow = mysqli_fetch_array($getMessageResult)) { 
        ?>
    <tr><div style = "margin: 10;">
    
    <td>    <h4 style = "color: black;display:inline;"><?=$getMessageRow['Name']?></h4></td>
    <?php
        if($getMessageRow['seen']=="yes"){
            echo "<td>  <i><p class='text-center' style = 'display:inline;'>".$getMessageRow['message']."</p></i></td>";
        }
        else{
            echo "<td>  <u><b><p class='text-center' style = 'display:inline;'>".$getMessageRow['message']."</p></b></u></td>";
        }
    ?>
        </div>
        </tr>
<?php } 
} 
else { 
    echo "<tr><td><p>How Can We Help You!!</p></td></tr>";
}
?>
</table>
<form class= action="" method = "POST" >
    <input type="button" value="Back" onclick="back()" class="btn btn-default"></input>
</form>
<script>
  function back() {
            window.location.href = "ViewMessages.php";
        }
</script>
