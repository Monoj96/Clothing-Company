<?php   
 session_start();  
 $connect = mysqli_connect("localhost", "root", "", "business");  
 if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["id"],  
                     'item_name'               =>     $_POST["hidden_name"],  
                     'item_type'          =>     $_POST["hidden_type"],  
                     'item_quantity'          =>     $_POST["quantity"]  
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="index.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["id"],  
                'item_name'               =>     $_POST["hidden_name"],  
                'item_type'          =>     $_POST["hidden_type"],  
                'item_quantity'          =>     $_POST["quantity"]  
           );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
 }  
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "delete")  
      {  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["item_id"] == $_GET["id"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     echo '<script>alert("Item Removed")</script>';  
                     echo '<script>window.location="cart.php"</script>';  
                }  
           }  
      }  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Clothing</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
                   <style>
                        *{
                             font-family:Century Gothic;
                        }
                   </style> 
          </head>  
      <body>
          <!-- nav            -->
          <ul class="nav nav-tabs">
          <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="cart.php">Store</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="createProduct.php">Create Product</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="report.php">Today's Sale</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="report2.php">Sales Report</a>
          </li>
          <li class="nav-item">
          <a class="nav-link disabled">Sale</a>
          </li>
          </ul> 
           <br />  
           <div class="container" style="width:700px;">  
                <h3 align="center">What are you looking for?</h3><br />  
                <!-- implementing search engine -->
                <div id="wrapper">
                <div id="search_box">
                    <form method="post"action="cart.php" onsubmit="return do_search();">
                        <div class="container h-100">
                            <div class="d-flex justify-content-center h-100">
                                <div class="searchbar">
                                    <input type="text" id="search_term"  class="search_input" name="search_term" placeholder="Please enter the keyword" onkeyup="do_search();">   
                
                                        <button  type="submit" class ="search_icon"  name="search"> <i class="fas fa-search"></i></button><hr>
                
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php  
                 if(isset($_POST['search']))
                 {
                   
                  $search_val = mysqli_real_escape_string($connect,$_POST['search_term']);
      
                  $get_result = "SELECT * FROM product WHERE  (productType LIKE ('%$search_val%') OR  productName LIKE ('%$search_val%')) AND productStatus = '0'";
                 
                  $result = mysqli_query($connect,$get_result) or die( mysqli_error($connect));
                  
                  while($row = mysqli_fetch_array($result) ){
                      $productId = $row['productId'];
                      $productName = $row['productName'];
                      $productType = $row['productType'];
                      $img = $row['img'];
                      $image_src = "imagesuploadedf/".$img;
                ?>  
                <div class="col-md-4">  
                     <form method="post" action="cart.php?action=add&id=<?php echo $row["productId"]; ?>">  
                          <div style="border:3px solid #E8E8E8; box-shadow: 2px 2px 2px #B8B8B8; background-color:#f1f1f1; border-radius:10px; padding:16px; margin:10px;" align="center">  
                              <img class="img-thumbnail" style="width:200px;"  alt="Responsive image" src='<?php echo $image_src;  ?>' ><br />  
                              <h4 class="text-primary"><?php echo $row["productName"]; ?></h4>  
                              <h4 class="text-danger"><?php echo $row["productType"]; ?></h4>  
                              <input type="number" name="quantity" class="form-control" value="1" required/>  
                              <input type="hidden" name="hidden_name" value="<?php echo $row["productName"]; ?>" />  
                              <input type="hidden" name="hidden_type" value="<?php echo $row["productType"]; ?>" />  
                              <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />  
                          </div>  
                     </form>  
                </div>  
                <?php  
                     }  
                }  
                ?>  
                <div style="clear:both"></div>  
                <br />  
                <h3>Order Details</h3>  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="40%">Item Name</th>
                               <th width="20%">Type</th>    
                               <th width="10%">Quantity</th>  
                               
                               <!-- <th width="15%">Total</th>   -->
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
                               <td><?php echo $values["item_type"]; ?></td>  
                               <td><?php echo $values["item_quantity"]; ?></td>  
                               
                               <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                             
                         </tr>  
                          
                          
                          <?php  
                                   
                              }                          
                          }  
                          ?>  
                     </table>
                      <!-- Sending data to sale.php page -->
                    <form method="POST" action="sale.php">
                                   <input type="hidden" name="item_id" value='<?php echo $values["item_id"]; ?>'>
                                   <input type="hidden" name="item_name" value='<?php echo $values["item_name"]; ?>'>
                                   <input type="hidden" name="item_type" value='<?php echo $values["item_type"]; ?>'>
                                   <input type="hidden" name="item_quantity" value='<?php echo $values["item_quantity"]; ?>'>
                                   <input type="submit"  name="checkout" class="btn btn-success" value="Checkout" /> 
                    </form> 
               
                </div>  
           </div>  
           <br />  
      </body>  
 </html>