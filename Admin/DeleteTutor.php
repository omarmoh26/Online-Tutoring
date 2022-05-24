<html>
<link rel="stylesheet" type="text/css" href ="DeleteAdminLearner.css">

<?php 
    include "AdminHome.php"; 
    if(isset($_POST['submit'])){
        $id=$_POST["id"];
        try{
            if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
                throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
            }
        }
        catch (customException $e) {
            echo $e->errorMessage();
        }

        $query ="delete from user where UserID='$id'";
        
        $results= $conn->query($query);
        
        if (!$results)
        trigger_error("<h1 style='color:red;'>Cannont delete this Tutor</h1>",E_USER_WARNING);
        else {
            header("Location:TutorsView.php");
        }
    }
?>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <h2 id="sign" class="active">Are you sure you want to remove this Tutor ?</h2>
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

            $query ="SELECT * FROM user where Type='tutor' and UserID=".$_GET["id"] ;
            
            $results= $conn->query($query);
            
            if (!$results)
                trigger_error("<h1 style='color:red;'>fatal error in executing query</h1>",E_USER_WARNING);
            
                while($row=$results->fetch_array(MYSQLI_ASSOC)){?>
                    <img src=../images/<?php echo $row['Image']?> alt='Italian Trulli' width='100' height='100'>
                    <input type="hidden" name="id" value= <?php echo $row['UserID']?> readonly>
                    <input  type="text" name="name"  value=<?php echo $row['Name']?> readonly>
                    <input type="text" name="email" value=<?php echo $row['Email']?> readonly>
                    <input type="text" name="password" placeholder="Password" value=<?php echo $row['Password']?> readonly>  
                    <input type="text" name="type" value=<?php echo $row["Type"]?> readonly><br>";
                <?php 
                }
            ?>
            <input type="submit" value="Delete tutor" name="submit">
            <input type="button" value="Cancel" onclick="cancel()"></input>

        </form>
    </div>
</div>              
	<script>
        function cancel() {
            window.location.href = "TutorsView.php";
        }
	</script>
</html>
