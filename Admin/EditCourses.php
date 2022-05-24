<html>
<link rel="stylesheet" type="text/css" href ="EditCourses.css">

<?php 
    include "AdminMenu.php";

    function currentTutors(){
		$tutID=array();
        try{
            if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
                throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
            }
        }
        catch (customException $e) {
            echo $e->errorMessage();
        }
        $sql="SELECT UserID FROM user where type='tutor' ";
        $result = mysqli_query($conn,$sql);	
        while($row=mysqli_fetch_array($result)){
            array_push($tutID,$row['UserID']);
        }
        $conn -> close();
        return $tutID;
    }
    if(isset($_POST['submit'])){
        $oldPic=$_POST['oldpic'];

        if($_FILES['myfile']['size']!=0 ){
            $dir='../images/';
            $fileName=$_FILES['myfile']['name'];
            move_uploaded_file($_FILES['myfile']['tmp_name'],$dir.$fileName);
        }
        else{
            $fileName=$oldPic;
        }

        $i=$_POST['id'];
        
        $c=$_POST['code'];
        $n=$_POST['name'];
        $d=$_POST['duration'];
        $p=$_POST['price'];
        $t=$_POST['tutorid'];
        $a=$_POST['approved'];

        $sanitizedCode=filter_var($c,FILTER_SANITIZE_STRING);
        $sanitizedName=filter_var($n,FILTER_SANITIZE_STRING);
        $sanitizedDuration=filter_var($d,FILTER_SANITIZE_NUMBER_INT);
        $sanitizedPrice=filter_var($p,FILTER_SANITIZE_NUMBER_INT);

        try{
            if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
                throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
            }
        }
        catch (customException $e) {
            echo $e->errorMessage();
        }

        if (filter_var($sanitizedDuration, FILTER_VALIDATE_INT) && filter_var($sanitizedPrice, FILTER_VALIDATE_INT)){
            $sql="update courses set courseCode='$sanitizedCode',courseName='$sanitizedName',courseDuration='$sanitizedDuration',
            coursePrice='$sanitizedPrice' ,TutorID='$t', Approved='$a',Image='$fileName' where CourseID ='$i' ";

            $result=mysqli_query($conn,$sql);
            
            if(!$result){
                trigger_error("<h1 style='color:red;'>Unable to Edit Courses</h1>",E_USER_WARNING);            
            }
            else{
                 header("Location:AdminCourses.php");
            }
        }
        else{
			trigger_error("<h1 style='color:red;'>Please Enter the data in the correct format</h1>",E_USER_WARNING);
        }
        
        $conn -> close();
    }
?>
<div class="wrapper">
    <div id="formContent">
        <h2 id="sign" class="active">Edit Course</h2>
        <form action='' method='post' onsubmit='return validate(this)' enctype='multipart/form-data'>
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
            trigger_error("<h1 style='color:red;'>fatal error in executing query</h1>",E_USER_WARNING);
        
        $myarr=currentTutors();   
        $fileName="";
        while($row=$results->fetch_array(MYSQLI_ASSOC)){
        echo "<input type=hidden name=oldpic value=".$row["Image"]."><br>";

        echo"<img src=../images/".$row["Image"]." alt='No Image' width='100' height='100'>";
        echo "<input type=hidden name=id value=".$row["CourseID"]."><br>";
        echo "Choose the New Photo: <input type='file' name='myfile' id='file' onchange='return fileValidation()'><br>";
        echo "Course Code <input type=text name=code value=".$row["courseCode"]."><br>";
        echo "Course Name <input type=text name=name value=".$row["courseName"]."><br>";
        echo "Course Duration <input type=text name=duration value=".$row["courseDuration"]."><br>";
        echo "Course Price<br><input type=text name=price value=".$row["coursePrice"]."><br>";
        echo "Tutor ID<br><select name=tutorid value=".$row["TutorID"]."><br>";
                for($i=0;$i<count($myarr);$i++){
                    if($myarr[$i]==$row["TutorID"]){
                        echo "<option selected>".$myarr[$i]."</option>";
                    }
                    else{
                        echo "<option>".$myarr[$i]."</option>";
                    }
                }
            echo "</select><br>";

        echo "Approved<br><select name='approved' value=".$row["Approved"]."><br>";
            if($row["Approved"]=='yes'){
                echo "<option selected>yes</option>";
                echo "<option>no</option>";
            }
            else{
                echo "<option >yes</option>";
                echo "<option selected>no</option>";
            }
            echo "</select><br>";
        }
        $conn -> close();
        echo"<input type='submit' value='Submit' name='submit'>";
        echo "<input type='button' value='Cancel' onclick='cancel()'></input>";
        echo "</form>";   
        ?>
    </div>
</div>  
   <head>
	<script>
        function cancel() {
            window.location.href = "AdminCourses.php";
        }
        function validatePic(field){
			if(field=='')
				return 'Choose a new Picture \n';
			else
				return '';
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

        function fileValidation() {
            var fileInput = 
                document.getElementById('file');
              
            var filePath = fileInput.value;
            var allowedExtensions = 
                    /(\.jpg|\.jpeg|\.png|\.gif)$/i;
              
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            } 
            else 
            {
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(
                            'imagePreview').innerHTML = 
                            '<img src="' + e.target.result
                            + '"/>';
                    };
                      
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }

	</script>
</head>
</html>
