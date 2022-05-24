<?php
include "LearnerMenu.php";

if(isset($_GET["action"]))  
{  
if($_GET["action"] == "delete")  
{  
     foreach($_SESSION["shopping_cart"] as $keys => $values)  
     {  
          if($values["item_id"] == $_GET["courseCode"])  
          {  
               unset($_SESSION["shopping_cart"][$keys]);   
               echo '<script>window.location="Cart.php"</script>';  
          }  
     }  
}  
} 
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
</style>


<div style="clear:both"></div>  
<br />  
<h3>Order Details</h3>  
<div class="table-responsive">  
     <table class="table table-light"> 
     <thead class="thead-dark"> 
          <tr>  
               <th width="40%">Course Name</th>   
               <th width="20%">Price</th>  
               <th width="15%">Total</th>  
               <th width="5%">Action</th>  
          </tr>  
          <?php   
          if(!empty($_SESSION["shopping_cart"]))  
          {  
               $total = 0;  
               foreach($_SESSION["shopping_cart"] as $keys => $values)  
               {  
          ?>  
          <tr>  
               <td><?php echo $values["item_name"]; ?></td>   
               <td>$ <?php echo $values["item_price"]; ?></td>  
               <td><a href="Cart.php?action=delete&courseCode=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
          </tr>  
          <?php  
                    $total = $total + ($values["item_price"]); 
               }  
          ?>  
          <tr>  
               <td colspan="3" align="right">Total</td>  
               <td align="right">$ <?php echo number_format($total, 2); ?></td>  
          </tr>  
          <?php  
          }  
          ?>  
          </thead>
     </table>  
</div>  
</div>  