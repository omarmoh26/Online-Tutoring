<html>
<link rel="stylesheet" type="text/css" href ="../Admin/AddCourse.css">

<?php 
include "TutorHome.php";
try{
	if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
		throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
	}
}
catch (customException $e) {
	echo $e->errorMessage();
	}
    if(isset($_POST['submit'])){
            
		if(!empty($_FILES['myfile']['size']!=0)){
			$dir='../images/';
			$fileName=$_FILES['myfile']['name'];
			move_uploaded_file($_FILES['myfile']['tmp_name'],$dir.$fileName);
			}
			else{
				$fileName="";
			}
        $c=$_POST['code'];
        $n=$_POST['name'];
        $d=$_POST['duration'];
        $p=$_POST['price'];
		$t=$_SESSION['ID'];
		$a="no";
        
        $sanitizedCode=filter_var($c,FILTER_SANITIZE_STRING);
        $sanitizedName=filter_var($n,FILTER_SANITIZE_STRING);
        $sanitizedDuration=filter_var($d,FILTER_SANITIZE_NUMBER_INT);
        $sanitizedPrice=filter_var($p,FILTER_SANITIZE_NUMBER_INT);
        

            if (filter_var($sanitizedDuration, FILTER_VALIDATE_INT) && filter_var($sanitizedPrice, FILTER_VALIDATE_INT)){

                $sql="INSERT INTO courses (courseCode, courseName,courseDuration, coursePrice, TutorID, Approved , Image ) 
                        VALUES ('$sanitizedCode','$sanitizedName','$sanitizedDuration','$sanitizedPrice','$t','$a','$fileName')";
                $result=mysqli_query($conn,$sql);
                
                if(!$result){
			    trigger_error("<h1 style='color:red;'>Unable to excute query</h1>",E_USER_WARNING);

                }
                else{
                    header("Location:CoursesTutor.php");
                }
            }
            else{
			trigger_error("<h1 style='color:red;'>Please Enter the data in the correct format</h1>",E_USER_WARNING);

            }
            $conn -> close();
    }
?>
<div class="wrapper fadeInDown">
    <div id="formContent">
	<h2 id="sign" class="active">Add New Course</h2>

		<form action="" method="post"  enctype='multipart/form-data' onsubmit='return validate(this)'>
		<input type=text name=code placeholder="Course Code">
			<input type=text name=name placeholder="Name">
			<input type=text name=duration placeholder="Duration">
			<input type=text name=price placeholder="Price"><br>
			<br><input type='file' name='myfile' id="file" onchange="return fileValidation()"><br>
			<input type="submit" value="Add" name="submit" >
			<input type="button" value="Cancel" onclick="cancel()"></input>
		</form>

	</div>
</div>		
<head>
	<script>
        function cancel() {
            window.location.href = "AdminCourses.php";
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
        }
	</script>
</head>
</html>