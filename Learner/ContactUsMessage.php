<link rel="stylesheet" type="text/css" href ="../Admin/ContactUsMessage.css">

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

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <div style = "margin: 10;">
        <th>    <h4 style = "display:inline;">Name</h4></th>
        <th>    <p class="text-center" style = "display:inline;">Message</p></th>
        <th>    <p class="text-center" style = "display:inline;">Link</p></th>
        <th>    <p class="text-center" style = "display:inline;">Image</p></th>
            </div>
        </tr>
        <?php
        $receiver = 0;
        if(isset($_POST['submit'])) {
            if(!empty($_FILES['myfile'])){
                $dir='../images/';
                $fileName=$_FILES['myfile']['name'];
                move_uploaded_file($_FILES['myfile']['tmp_name'],$dir.$fileName);
                }
                else{
                    $fileName="";
                }

        $createdAt = date("Y-m-d h:i:sa");
        $sent_by = $_SESSION['ID'];
        $message = filter_var($_POST['message'],FILTER_SANITIZE_STRING);
        
        $l =filter_var($_POST['link'],FILTER_SANITIZE_URL);
        if(!filter_var($l,FILTER_VALIDATE_URL)){
            $l="";
        }

        $sendMessage = "INSERT INTO contactus (sent_by,received_by,message,createdAt,link,Image) 
                            VALUES('$sent_by','0','$message','$createdAt','$l','$fileName')";

        mysqli_query($conn,$sendMessage) or trigger_error("<h1 style='color:red;'>Can't Send Your Message</h1>",E_USER_WARNING);
        }

        $getMessage = "SELECT  contactus.* ,user.Name FROM contactus INNER JOIN user on sent_by=user.UserID  WHERE sent_by = '0' AND received_by = ".$_SESSION['ID']." OR sent_by = ".$_SESSION['ID']." AND received_by = '0' OR received_by = ".$_SESSION['ID']." ORDER BY createdAt asc";
        $getMessageResult = mysqli_query($conn,$getMessage) or trigger_error("<h1 style='color:red;>Canno't show Messages</h1>",E_USER_WARNING);

        if(mysqli_num_rows($getMessageResult) > 0) {
            while($getMessageRow = mysqli_fetch_array($getMessageResult)) { ?>
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
            echo "<h1 style='left:600; position:relative;'>How Can We Help You!!</h1>";
        }
        ?>
    </thead>
</table>
<div class="wrapper fadeInDown">
<form class= action="" method = "POST" enctype='multipart/form-data'>
    <textarea name = "message" rows="4" cols="100" maxlength="100" size="20" placeholder = "Type your message here" required></textarea>
    <input type="url" name="link"  placeholder="Paste The Course Link you want..." style="  background-color:lightgrey;">
    <input type='file' name='myfile' id="file" onchange="return fileValidation()"><br>
    <input type = "submit" value='send' name='submit' class="btn btn-default">
    <input type="button" value="Cancel" onclick="cancel()" class="btn btn-default"></input>
</form>
<script>
  function cancel() {
            window.location.href = "LearnerHome.php";
        }
        function fileValidation() {
            var fileInput = 
                document.getElementById('file');
              
            var filePath = fileInput.value;
            var allowedExtensions = 
                    /(\.jpg|\.jpeg|\.png|\.gif)$/i;
              
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            } 
        }
</script>
