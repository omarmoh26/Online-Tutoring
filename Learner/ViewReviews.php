<?php
include "LearnerMenu.php";

function getUserName($cid){
    try{
        if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
            throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
        }
        
    $sql="SELECT Name FROM user WHERE UserID=".$cid ;
    $result = mysqli_query($conn,$sql);	
    
    if($row=mysqli_fetch_array($result)){
         if($row["Name"]==0)
             echo "User";
         else
             echo $row["Name"];
    }
    $conn->close();
}
    catch(customException $e){
        echo $e->getMessage();
        }
}
?>
<style>
    table th{
        padding: 10px;
        text-align: center;
    }
    table td{
        padding: 10px;
        text-align: center;
    }
</style>
<table  class="table table-light">
  <thead class="thead-dark">
    <tr>
        <th>Learner Name</th>
        <th>Review</th>
    </tr>

<?php
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}
    $sql="SELECT LearnerID,review FROM review WHERE courseID=".$_GET["id"];
    $result = mysqli_query($conn,$sql);	
    while($row=mysqli_fetch_array($result)){
?>
    <tr>
    <td><?php echo getUserName($row['LearnerID']) ?></td>

    <td><?php echo $row['review'] ?></td>
    </tr>
<?php } ?>
    </thead>
</table>