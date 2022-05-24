
<?php 
	include "LearnerMenu.php";
  include "SearchBar.php";


  if(isset($_POST["add_to_cart"]))  
  {  
    if(isset($_SESSION["shopping_cart"]))  
    {  
      $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
      if(!in_array($_GET["courseCode"], $item_array_id))  
      {  
            $count = count($_SESSION["shopping_cart"]);  
            $item_array = array(  
                'item_id'               =>     $_GET["courseCode"],   
                'item_name'               =>     $_POST["hidden_name"],  
                'item_price'          =>     $_POST["hidden_price"]     
            );  
            $_SESSION["shopping_cart"][$count] = $item_array;

        }  
        else  
        {  
              echo '<script>window.location="CoursesLearner.php"</script>';  
        }  
    }  
    else  
    {  
        $item_array = array(  
              'item_id'               =>     $_GET["courseCode"],  
              'item_name'               =>     $_POST["hidden_name"],  
              'item_price'          =>     $_POST["hidden_price"]  
        );  
        $_SESSION["shopping_cart"][0] = $item_array;  
    }  
  }

  try{
    if(($conn = new mysqli("localhost", "root", "", "online_tutoringdb"))-> connect_errno){
      throw new customException("<h1 style='color:red;'>Unable to Connect</h1>");
    }
  }
  catch (customException $e) {
    echo $e->errorMessage();
    }
  $sql="SELECT * FROM courses where Approved='yes' ";
  $result = mysqli_query($conn,$sql);	
  $counter=1;
  while($row=mysqli_fetch_array($result)){

?> 
<div class="card" style="width: 18rem;">
  <img src=../images/<?php echo $row['Image']?> width='50' height='50' class="card-img-top" alt="Card image cap">
    <div class="card-body">
    <h5 class="card-title"><?php echo $row['courseName']?></h5>
        <p class="card-text"><?php echo $row['courseDuration']." Months" ?></p>
        <p class="card-text"><?php echo $row['coursePrice']." $" ?></p>
    </div>
  </div>
  
 
<?php }?>

