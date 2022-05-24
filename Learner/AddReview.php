<link rel="stylesheet" type="text/css" href ="AddReview.css">

<?php
include "LearnerMenu.php"; 

try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}
if(isset($_POST['Submit'])){ 
	$r=$_POST['review'];
	$s=$_POST['star'];
    $LID=$_SESSION['ID'];
    $CID=$_GET["id"];
	
	$sanitizedreview=filter_var($r,FILTER_SANITIZE_STRING);
		
		$sql="INSERT INTO review (LearnerID,courseID,review,rating)
                 VALUES ('$LID','$CID','$sanitizedreview','$s')";

        $result=mysqli_query($conn,$sql);
        if($result)	{
            echo "<script>window.location.href = 'CoursesLearner.php';</script>";
        }
        else{
            trigger_error("<h1 style='color:red;'>Unable Add Your Review</h1>",E_USER_WARNING);

        }
}

$sql="SELECT * FROM courses WHERE courseID=".$_GET["id"];
$result = mysqli_query($conn,$sql);	
if($row=mysqli_fetch_array($result))
{
    ?>
    <form action="" method="post" onsubmit='return validate(this)'>
    <table  class="table table-light">
        <thead class="thead-dark">
        
            <tr>
            <th>Course Image</th>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Course Duration</th>
            <th>Course Price</th>
            <th>Review</th>
            <th>Rating</th>
            </tr>
    
            <tr>
            <td><img src='../images/<?php echo $row['Image']?>' alt='Italian Trulli' width='100' height='100'> </td>
            <td><?php echo $row['courseCode'] ?></td>
            <td><?php echo $row['courseName'] ?></td>
            <td><?php echo $row['courseDuration']." Months" ?></td>
            <td><?php echo $row['coursePrice']." $" ?></td>

            <td><textarea name="review" rows="4" cols="40" placeholder="Enter Your Review Here..."></textarea></td>
            <td> <select name="star">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select> 
            </td>
            <td><input type="submit" name="Submit" value="Submit"><br><br>
            <input type="button" value="Cancel" onclick="cancel()"></input>
            </td>
        </tr>
</table>
</form>
        
<?php
}
?>
<script>
    function cancel() {
            window.location.href = "LearnerHome.php";
        }
    function validateReview(field){
			if(field=='')
				return 'No review was entered \n';
			else
				return '';
		}
		function validate(form){
			fail='';
			fail+=validateReview(form.review.value);
			if(fail=='')
				return true;
			else{
				alert(fail);
				return false;
			}
		}
</script>