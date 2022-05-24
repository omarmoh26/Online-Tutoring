<?php
include "LearnerMenu.php";
?>

<table  class="table table-light">
  <thead class="thead-dark">
    <tr>
        <th>Count</th>
        <th>Rating</th>
    </tr>

<?php
 try{
    if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
        throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
    }
    $sql="SELECT rating ,COUNT(*) As count  FROM review WHERE courseID=".$_GET["id"]." GROUP BY rating";
    $result = mysqli_query($conn,$sql);	
    while($row=mysqli_fetch_array($result)){
?>
    <tr>
    <td><?php echo $row['count'] ?></td>
    <td><?php echo $row['rating'] ?></td>
    </tr>
<?php } 
}
 catch(customException $e){
    echo $e->getMessage();
    }
?>
    </thead>
</table>
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