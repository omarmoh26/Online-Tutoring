<?php
include "AdminMenu.php";
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
<table border=2 class="table table-light">
  <thead class="thead-dark">
            <tr>
                <th>Image</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Type</th>
                <th>Edit</th>
                <th>Delete</th>
                <th> <a href="AddNewTutor.php"> ADD New Tutor</a> </th>
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
            $sql="SELECT * FROM user where type='tutor' ";
            $result = mysqli_query($conn,$sql);	
            if (!$result)
                trigger_error("<h1 style='color:red;'>fatal error in executing query</h1>",E_USER_WARNING);
            while($row=mysqli_fetch_array($result)){
        ?>
            <tr>
            <td><img src=../images/<?php echo $row['Image']?> alt='Italian Trulli' width='100' height='100'> </td>
            <td><?php echo $row['UserID'] ?></td>
            <td><?php echo $row['Name'] ?></td>
            <td><?php echo $row['Email'] ?></td>
            <td><?php echo $row['Password'] ?></td>
            <td><?php echo $row['Type'] ?></td>
            <td> <a href=EditTutors.php?id=<?php echo $row['UserID'] ?>> EDIT</a> </td>
            <td> <a href=DeleteTutor.php?id=<?php echo $row['UserID'] ?>> DELETE</a> </td>
            </tr>
        <?php } ?>
    </thead>
</table>