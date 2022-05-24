<html>
<link rel="stylesheet" type="text/css" href ="EditAdminLearner.css">

<?php 
    include "AdminHome.php"; 
    if(isset($_POST['submit'])){
        $i=$_POST['id'];
        $n=$_POST['name'];
        $e=$_POST['email'];
        $p=$_POST['password'];
        $t=$_POST['usertype'];

        $sanitizedName=filter_var($n,FILTER_SANITIZE_STRING);
        $sanitizedEmail=filter_var($e,FILTER_SANITIZE_EMAIL);
        $sanitizedPass=filter_var($p,FILTER_SANITIZE_STRING);

        try{
            if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
                throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
            }
        }
        catch (customException $e) {
            echo $e->errorMessage();
        }
            if (filter_var($sanitizedEmail,FILTER_VALIDATE_EMAIL)){
            $sql="update user set Name='$sanitizedName',Email='$sanitizedEmail',Password='$sanitizedPass',Type='$t'  where UserID='$i'";
            $result=mysqli_query($conn,$sql);
            
            if(!$result){
				trigger_error("<h1 style='color:red;'>Unable to Edit Learner</h1>",E_USER_WARNING);
            }
            else{
                 header("Location:LearnersView.php");
            }
        }
        else{
			trigger_error("<h1 style='color:red;'>Please enter your Email correctly</h1>",E_USER_WARNING);
        }
        
        $conn -> close();
    }
    ?>

<div class="wrapper ">
    <div id="formContent">
        <h2 id="sign" class="active">Edit Learner</h2>
        <form action='' method='post' onsubmit='return validate(this)'>
        <?php
       try{
        if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
            throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
        }
        }
        catch (customException $e) {
            echo $e->errorMessage();
            }

        $query ="select * from user where UserID=".$_GET["id"];
        $results= $conn->query($query);
        
        if (!$results)
            trigger_error("<h1 style='color:red;'>fatal error in executing query</h1>",E_USER_WARNING);

        
            while($row=$results->fetch_array(MYSQLI_ASSOC)){ ?>

                <select name='usertype'  value=<?php echo $row['Type']?>>
                <option selected>learner</option>
                <option >administrator</option>
                <option>auditor</option>
                <option>tutor</option>
                </select><br>
                
                <input type=hidden name=id value= <?php echo $row['UserID']?>>
                <input  type=text name=name placeholder="Name" value=<?php echo $row['Name']?>>
                <input type=text name=email placeholder="Email" value=<?php echo $row['Email']?>>
                <input type=text name=password placeholder="Password" value=<?php echo $row['Password']?>>
        <?php 
        }
        $conn -> close();
        ?>
        <input type="submit" value="Submit" name="submit">
        <input type="button" value="Cancel" onclick="cancel()"></input>
        </form>
    </div>
</div> 
   <head>
	<script>
        function cancel() {
            window.location.href = "LearnersView.php";
        }
		function validateCode(field){
			if(field=='')
				return 'No Course Code was entered \n';
			else
				return '';
		}
		function validateName(field){
			if(field=='')
				return 'No Course Name was entered \n';
			else
				return '';
		}
		function validateDuration(field){
			if(field=='')
				return 'No Course Duration was entered \n';
			else
				return '';
		}
		function validatePrice(field){
			if(field=='')
				return 'No Course Price was entered \n';
			else
				return '';
		}
		
		function validate(form){
			fail='';
			fail+=validateCode(form.code.value);
			fail+=validateName(form.name.value);
			fail+=validateDuration(form.duration.value);
			fail+=validatePrice(form.price.value);
			if(fail==''){
				return true;	
			}
				
			else{
				alert(fail);
				return false;
			}
		}
	</script>
</head>
</html>
