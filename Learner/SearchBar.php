<link rel="stylesheet" type="text/css" href ="SearchBar.css">
<?php
    try{
        if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
            throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
        }
    }
    catch (customException $e) {
        echo $e->errorMessage();
        }

if(isset($_POST['submitsearch'])){
			
    $search_value=filter_var($_POST["course"],FILTER_SANITIZE_STRING);

    $sql="SELECT * FROM courses WHERE Approved='yes' and (courseCode ='$search_value' OR courseName ='$search_value')";
    $result = mysqli_query($conn,$sql);	

    if($row=mysqli_fetch_array($result))
    {
        ?>
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
        
                <tr>
                <td><img src=../images/<?php echo $row['Image']?> alt='Italian Trulli' width='100' height='100'> </td>
                <td><?php echo $row['courseCode'] ?></td>
                <td><?php echo $row['courseName'] ?></td>
                <td><?php echo $row['courseDuration']." Months" ?></td>
                <td><?php echo $row['coursePrice']." $" ?></td>
            <div class="linksinmenu">
                <td> <a href=ViewReviews.php?id=<?php echo $row['CourseID'] ?>> View Reviews</a> </td>
                <td> <a href=ViewRatings.php?id=<?php echo $row['CourseID'] ?>><?php echo Avg_Rating ($row['CourseID']) ?> </a></td>
                <td> <a href=AddReview.php?id=<?php echo $row['CourseID'] ?>> Add Reviews</a> </td>
            </div>
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
    <?php
    }
    else	
    {
        echo "<h1 style='color:red; left:600; position:relative;'>Enter Correct Course name or CourseID</h1>";
    }   
}
?>
<div class="topnav">
		<div class="search-box">

<form action="" method="post" onsubmit='return validate(this)'>
	<button type="submit" name="submitsearch" class="btn-search"><i class="fas fa-search"></i></button>
	<input type="text" name="course" class="input-search" placeholder="Type to Search...">
</form>

</div>
<style>
    .linksinmenu a:hover, a:active{
        background-color: red;
    }
    .linksinmenu  a:link, a:visited {
        background-color: #f44336;
        color: white;
        padding: 10px 18px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }
    .topnav i{
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
</style>