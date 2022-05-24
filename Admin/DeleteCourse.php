<html>
<link rel="stylesheet" type="text/css" href ="EditCourses.css">

<?php 
    include "AdminMenu.php"; 
    if(isset($_POST['submit'])){
        try{
            if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
                throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
            }
        }
        catch (customException $e) {
            echo $e->errorMessage();
        }
        $query ="delete from courses where CourseID=".$_POST["id"];
        $results= $conn->query($query);
        
        if (!$results)
            trigger_error("<h1 style='color:red;'>Cannont delete this Course</h1>",E_USER_WARNING);
        else {
            header("Location:AdminCourses.php");
        }
    }
    ?>
<div class="wrapper">
    <div id="formContent">
        <h2 id="sign" class="active">Are you sure you want this Course ?</h2>
        <form action="" method="post" >
            <?php
            try{
                if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
                    throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
                }
            }
            catch (customException $e) {
                echo $e->errorMessage();
            }

            $query ="select * from courses where CourseID=".$_GET["id"];
            $results= $conn->query($query);
            
            if (!$results)
                trigger_error("<h1 style='color:red;'>Cannont Select Courses</h1>",E_USER_WARNING);
            
            while($row=$results->fetch_array(MYSQLI_ASSOC)){
            echo "<input type=hidden name=id value=".$row["CourseID"]." readonly><br>";
            echo "Course Code:<input type=text name=code value=".$row["courseCode"]." readonly><br>";
            echo "Course Name:<input type=text name=name value=".$row["courseName"]." readonly><br>";
            echo "Course Duration:<input type=text name=duration value=".$row["courseDuration"]." readonly><br>";
            echo "Course Price <br> <input type=text name=price value=".$row["coursePrice"]." readonly><br>";
            echo "Tutor ID <br> <input type=text name=tutorid value=".$row["TutorID"]." readonly><br>";
            echo "Approved<br><input type=text name='approved' value=".$row["Approved"]." readonly><br>";
            }
            ?>
            <input type="submit" value="Delete Course" name="submit">
            <input type="button" value="Cancel" onclick="cancel()"></input>

        </form>
    </div>
</div>  
   <head>
	<script>
        function cancel() {
            window.location.href = "AdminCourses.php";
        }
	</script>
</head>
</html>
