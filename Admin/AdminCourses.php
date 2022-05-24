<?php
include "AdminMenu.php";
?>
<style>
    table th{
        padding: 10px;
        position: relative;
        text-align: center;
    }
    
    table td{
        padding: 10px;
        text-align: center;
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
<table border=2 class="table table-light">
  <thead class="thead-dark">
            <tr>
            <th>Course Image</th>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Course Duration</th>
            <th>Course Price</th>
            <th>Approved</th>
            <th>TutorID</th>
            <th>Edit</th>
            <th>Delete</th>
            <th> <a href="AddCourse.php"> ADD New Course</a> </th>
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
            $sql="SELECT * FROM courses ";
            $result = mysqli_query($conn,$sql);	
            while($row=mysqli_fetch_array($result)){
        ?>
            <tr>
            <td><img src=../images/<?php echo $row['Image']?> alt='Italian Trulli' width='100' height='100'> </td>
            <td><?php echo $row['courseCode'] ?></td>
            <td><?php echo $row['courseName'] ?></td>
            <td><?php echo $row['courseDuration']." Months" ?></td>
            <td><?php echo $row['coursePrice']." $" ?></td>
            <td><?php echo $row['Approved'] ?></td>
            <td><?php echo $row['TutorID'] ?></td>
            <td> <a href=EditCourses.php?id=<?php echo $row['CourseID'] ?>> EDIT</a> </td>
            <td> <a href=DeleteCourse.php?id=<?php echo $row['CourseID'] ?>> DELETE</a> </td>
            </tr>
        <?php } ?>
    </thead>
</table>