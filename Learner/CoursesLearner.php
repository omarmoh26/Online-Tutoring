<html>

<?php
include "LearnerMenu.php";
include "SearchBar.php";
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
        
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}

if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["courseCode"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'item_id' =>  $_GET["courseCode"],   
                     'item_name' => $_POST["hidden_name"],  
                     'item_price' => $_POST["hidden_price"]     
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;
           }  
           else  
           {  
                echo '<script>window.location="CoursesLearner.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id' =>  $_GET["courseCode"],  
                'item_name' =>  $_POST["hidden_name"],  
                'item_price' => $_POST["hidden_price"]  
           );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
 }

?>
<style>

    table{
        
        scroll-behavior: smooth;
        max-height: 20em;
    }
    table th{
        padding: 10px;
        text-align: center;
        
    }
    table td{
        padding: 10px;
        text-align: center;
    }
    table td a:hover, a:active{
        background-color: red;
    }
    table td a:link, a:visited {
        background-color: #f44336;
        color: white;
        padding: 10px 18px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }
</style>
<table  class="table table-light">
  <thead class="thead-dark">
    <tr>
        <th>Course Image</th>
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Course Duration</th>
        <th>Course Price</th>
        <th>Reviews</th>
        <th>Average Rating</th>
        <th>Add Review</th>
        <th>Buy</th>
    </tr>

<?php

    $sql="SELECT * FROM courses where Approved='yes' ";
    $result = mysqli_query($conn,$sql);	
    while($row=mysqli_fetch_array($result)){
?>
    <tr>
    <td><img src=../images/<?php echo $row['Image']?> alt='Italian Trulli' width='100' height='100'> </td>
    <td><?php echo $row['courseCode'] ?></td>
    <td><?php echo $row['courseName'] ?></td>
    <td><?php echo $row['courseDuration']." Months" ?></td>
    <td><?php echo $row['coursePrice']." $" ?></td>
    <td> <a href=ViewReviews.php?id=<?php echo $row['CourseID'] ?>> View Reviews</a> </td>
    <td> <a href=ViewRatings.php?id=<?php echo $row['CourseID'] ?>><?php echo Avg_Rating ($row['CourseID']) ?> </a></td>
    <td> <a href=AddReview.php?id=<?php echo $row['CourseID'] ?>> Add Reviews</a> </td>
    <td align="center">
    <div class="col-md-4">  
        <form method="post" action="CoursesLearner.php?action=add&courseCode=<?php echo $row["courseCode"]; ?>">  
            <div>  
                <input type="hidden" name="hidden_name" value="<?php echo $row["courseName"]; ?>" />  
                <input type="hidden" name="hidden_price" value="<?php echo $row["coursePrice"]; ?>" />  
                <input type="submit" name="add_to_cart" style="margin-top:6px;font-size:13px;" class="btn btn-success"  value="Add to Cart" />  
            </div>  
        </form>  
    </div>  
    </td>
    </tr>
<?php } ?>
    </thead>
</table>
</html>