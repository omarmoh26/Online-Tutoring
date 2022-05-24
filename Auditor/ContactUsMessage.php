<link rel="stylesheet" type="text/css" href ="../Admin/ContactUsMessage.css">

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
<table class="table table-striped">
    <thead class="thead-dark">
        <tr><div style = "margin: 10;">
            <th>    <h4 style = "color: black;display:inline;">Name</h4></th>
            <th>    <p class="text-center" style = "display:inline;">Message</p></th>
            <th>    <p class="text-center" style = "display:inline;">Link</p></th>
            <th>    <p class="text-center" style = "display:inline;">Image</p></th>
                </div>
            </tr>
        <?php
        $receiver = $_GET['receiver'];
        if(isset($_POST['submit'])) {

        $createdAt = date("Y-m-d h:i:sa");
        $receiver = $_POST['received_by'];
        $message = $_POST['message'];
        $sender=$_SESSION['ID'];
        $sendMessage = "INSERT INTO contactus (sent_by,received_by,message,createdAt) 
                            VALUES('$sender','$receiver','$message','$createdAt')";
        mysqli_query($conn,$sendMessage) or trigger_error("<h1 style='color:red;'>Can't Send Your Message</h1>",E_USER_WARNING);
        }

        $getMessage = "SELECT  contactus.* ,user.Name FROM contactus INNER JOIN user on sent_by=user.UserID  WHERE sent_by='$receiver' and received_by = '0' OR sent_by = '0' or sent_by = ".$_SESSION['ID']." and received_by='$receiver'  ORDER BY createdAt asc";
        $getMessageResult = mysqli_query($conn,$getMessage) or trigger_error("<h1 style='color:red;>Canno't show Messages</h1>",E_USER_WARNING);
        if(mysqli_num_rows($getMessageResult) > 0) {
            while($getMessageRow = mysqli_fetch_array($getMessageResult)) { 
                ?>
            <tr><div style = "margin: 10;">
            
            <td>    <h4 style = "color: black;display:inline;"><?=$getMessageRow['Name']?></h4></td>
            <td>    <p class="text-center" style = "display:inline;"><?=$getMessageRow['message']?></p></td>
            <td>    <p class="text-center" style = "display:inline;"><?=$getMessageRow['link']?></p></td>
                <?php if(!empty($getMessageRow['Image'])){?>
                    <td>    <p class="text-center" style = "display:inline;"><img src=../images/<?php echo $getMessageRow['Image']?> width='100' height='100'></p></td>
                <?php } ?>
                </div>
                </tr>
        <?php } 
        } 
        else { 
            echo "<tr><td><p>How Can We Help You!!</p></td></tr>";
        }
        ?>
    </thead>
</table>
<div class="wrapper ">
    <form class= action="" method = "POST" enctype='multipart/form-data'>
        <input type="hidden" name = "sent_by" value = "<?=$_SESSION['ID']?>"/>
        <input type="hidden" name = "received_by" value = "<?=$receiver?>"/>
        <textarea name = "message" rows="4" cols="100" maxlength="100" size="20" placeholder = "Type your message here" required/></textarea><br>
        <input type = "submit" value='send' name='submit' class="btn btn-default">
        <input type="button" value="Cancel" onclick="cancel()" class="btn btn-default"></input>
    </form>
</div>
<script>
  function cancel() {
            window.location.href = "AuditorHome.php";
        }
</script>
