<?php
include "AdminMenu.php";
?>
<style>
    table th{
        padding: 10px;
    }
    table td{
        padding: 10px;
        text-align: center;
    }
</style>
<table border=2 class="table table-light">
  <thead class="thead-dark">
            <tr>
                <th>Order ID</th>
                <th>Cart ID</th>
                <th>Learner ID</th>
                <th>Total Price</th>
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
            $sql="SELECT * FROM orders ";
            $result = mysqli_query($conn,$sql);	
            while($row=mysqli_fetch_array($result)){
        ?>
            <tr>
            <td><?php echo $row['orderID'] ?></td>
            <td><?php echo $row['cartID'] ?></td>
            <td><?php echo $row['LearnerID']." Months" ?></td>
            <td><?php echo $row['TotalPrice']." $" ?></td>
            </tr>
        <?php } ?>
    </thead>
</table>