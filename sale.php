<?php
//connect to database
$db=mysqli_connect("localhost","root","","business");

session_start(); 
date_default_timezone_set("Australia/Sydney");  
if(isset($_POST['sale_btn']))
{

    

    $orderDate = date("Y-m-d");
    $orderTime = date("h:i:sa");
    $orderAmount=mysqli_real_escape_string($db,$_POST['orderAmount']);
    $paymentType=mysqli_real_escape_string($db,$_POST['paymentType']);

  
 
    $sql="INSERT INTO orders (orderDate,  orderTime , orderAmount, paymentType) VALUES('$orderDate', '$orderTime','$orderAmount', '$paymentType')"; 
    $sql_run = mysqli_query($db,$sql);

    if($sql_run){ 
        

    }else{
    
    } 

    $find_orderId = "SELECT orderId from orders ORDER BY orderId DESC";
    $result = mysqli_query($db,$find_orderId);

    while($row = mysqli_fetch_array($result) ){
        $orderId = $row['orderId'];


        if(!empty($_SESSION["shopping_cart"]))  
        {   
            foreach($_SESSION["shopping_cart"] as $keys => $values)  
            { 
                    $productId= $values["item_id"];
                    $quantity= $values["item_quantity"];


                $sql2= "INSERT INTO orderdetails (orderId,  productId , Quantity) VALUES('$orderId', '$productId','$quantity')"; 
                $sql2_run = mysqli_query($db,$sql2);  
                
                if($sql2_run){ 
                   
                    unset($_SESSION['shopping_cart']);
                    echo '<script>alert("you have successfully placed your order")</script>';  
                    echo '<script>window.location="report.php"</script>'; 
            
                }else{
                    echo '<script>alert("ERROR! Please try again.")</script>';  
                    echo '<script>window.location="cart.php"</script>'; 
                }
            }
        }         
    }    
    
    
}



if(isset($_POST['checkout']))
{
    $text ="";
    if(isset($_SESSION["shopping_cart"]))  
    {  
        foreach ($_SESSION["shopping_cart"] as $item_array)
        { 
            
            $item[] = $item_array;
            $item_id = $item_array["item_id"];
            $item_name = $item_array["item_name"];
            $item_type = $item_array["item_type"];
            $item_quantity = $item_array["item_quantity"];
          
        }    
        
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <style>
                *{
                    font-family:Century Gothic;
                }
            </style>
           <title>Place order</title>
</head>
<body>
  
    <div class="container" style="width:700px;"> 
        <h1>Order Details</h1>  
        <div class="table-responsive">  
            <table class="table table-bordered">  
                <tr>  
                    <th width="5%">Order no</th>
                    <th width="40%">Item Name</th>
                    <th width="20%">Type</th>    
                    <th width="10%">Quantity</th> 
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
                    <td><?php echo $values["item_id"]; ?></td>    
                    <td><?php echo $values["item_name"]; ?></td>  
                    <td><?php echo $values["item_type"]; ?></td>  
                    <td><?php echo $values["item_quantity"]; ?></td>  
               
                    <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger"><i class="fas fa-times-circle"></i></span></a></td>  
                    
                </tr>  
            
            </table>
            <form method="POST" action="sale.php">
                <table class="table table-bordered">    
                    <?php  
                        
                    }                          
                }  
                ?>  
                    <tr>
                        <td>Payment Type : </td>
                        <td>
                            <input type="radio" name="paymentType" class="textInput" value="0" checked> <i class="fas fa-money-bill-wave" style="text-align:center"></i>Cash
                            <input type="radio" name="paymentType" class="textInput"value="1" > <i class="fab fa-cc-mastercard"></i>Card
                        </td>
                    </tr>
                    <tr>
                        <td>Total due: </td>
                        <td>$ <input type="number" name="orderAmount" class="textInput" required>.00 AUD</td>
                    </tr>
                    <tr>
                        <td><?php echo date("Y-m-d")  .date("h:i:sa") ?>  </td>
                        <td><input class= "btn btn-success btn-block" type="submit" name="sale_btn" value='Sold!'></td>
                    </tr>
                </table>
            </form>    
        </div>  
    </div>       
</body>
</html>