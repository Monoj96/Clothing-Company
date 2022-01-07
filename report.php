<?php

//connect to database
$db=mysqli_connect("localhost","root","","business");
date_default_timezone_set("Australia/Sydney");
$today= date("Y-m-d");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <!-- CSS only -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
           <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>  
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <style>
                *{
                    font-family:Century Gothic;
                    font-size:15px;
                }
                table{
                    font-size:15px;
                }

            </style>
    <title>Sales Report</title>

</head>
<body>
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
    <div class="container" style="width:700px;">
        <h3 align="center"><b>Sales Report</b></h3>
        <h6 align="center">Date: <?php echo date(" d-m-y") ?></h6> 
        <div class="table-responsive">  
            <table class="table table-bordered">  
                <tr>  
                    <th width="10%">Order no</th>
                    <th width="60%">Item Name Type Quantity </th>
                    <th width="10%">Payment Type</th>
                    <th width="20">Amount</th>
                </tr> 
                <?php

                    $findOrderId = "SELECT * FROM orders WHERE orderDate LIKE '$today'";

                    $query = mysqli_query($db,$findOrderId);

                    while($row = mysqli_fetch_array($query) ){

                        $orderId = $row['orderId'];
                        $paymentType = $row['paymentType'];
                        $orderAmount = $row['orderAmount'];   
                ?>


                <tr>
                    <td><?= $orderId ?></td>
                    <td>
                        <?php
                             $sql= "SELECT orders.orderId, orderdetails.productId, orderdetails.quantity,orders.paymentType,
                             orders.orderDate, orders.orderAmount, product.productName,product.productType 
                             FROM orders 
                             INNER JOIN orderdetails 
                             ON orders.orderId = orderdetails.orderId 
                             INNER JOIN product 
                             ON orderdetails.productId = product.productId
                            WHERE orders.orderId like '$orderId'
                            ";
                             
                             $result = mysqli_query($db,$sql);
         
                             while($row = mysqli_fetch_array($result) ){
                               
                                 $productName = $row['productName'];
                                 $productType = $row['productType'];
                                 $quantity = $row['quantity'];

                                echo $productName." ";
                                echo $productType." ";
                                echo $quantity."<br>";
                             } 
                        ?>

                        <br>

                    </td>
                 
                    <?php
                                                      
                        if($paymentType == '0'){ 
                    ?>
                         <td>Cash</td>   
                       <?php }else{
                        ?>
                        <td>Card</td>    
                       <?php } ?>
                    
                    <td><?= $orderAmount ?></td>
                    
                </tr>

                <?php
                                
                    }  
                ?>
            </table>    
        </div>

        <h3 align="center"> Summary</h3>
        <table class="table table-success table-bordered">
            <tr>
                <?php
                      $sql= "SELECT SUM(orderAmount) AS TotalorderAmount FROM orders
                        WHERE orderDate LIKE '$today'
                        ";
                      
                      $result = mysqli_query($db,$sql);
  
                      while($row = mysqli_fetch_array($result) ){
                        
                         
                          $TotalorderAmount = $row['TotalorderAmount'];

                      
                ?>
                <th>Total Sale</th>
                <td><?php echo $TotalorderAmount; ?></td>
                <?php
                      }
                ?>
            </tr>
            
            <tr>
                <?php
                      $sql2= "SELECT SUM(orderAmount) AS TotalcardAmount 
                      FROM orders
                      WHERE paymentType = '1'
                      AND orderDate LIKE '$today'
                        ";
                      
                      $result = mysqli_query($db,$sql2);
  
                      while($row = mysqli_fetch_array($result) ){
                        
                         
                          $TotalcardAmount = $row['TotalcardAmount'];

                      
                ?>
                <th>Card Sale</th>
                <td><?php echo $TotalcardAmount; ?></td>
                <?php
                      }
                ?>
            </tr>
            <tr>
                <?php
                      $sql3= "SELECT SUM(orderAmount) AS TotalCashAmount 
                      FROM orders
                      WHERE paymentType ='0'
                      AND orderDate LIKE '$today'
                      ";
                      
                      $result = mysqli_query($db,$sql3);
  
                      while($row = mysqli_fetch_array($result) ){
                        
                         
                          $TotalCashAmount = $row['TotalCashAmount'];

                      
                ?>
                <th>Cash Sale</th>
                <td><?php echo $TotalCashAmount; ?></td>
                <?php
                      }
                ?>
            </tr>
            <tr>
                <?php
                      $sql4= "SELECT SUM(quantity) AS TotalQuantity 
                      FROM orderdetails
                      INNER JOIN orders ON orders.orderId = orderdetails.orderId
                      WHERE orderDate LIKE '$today'
                      ";
                      
                      $result = mysqli_query($db,$sql4);
  
                      while($row = mysqli_fetch_array($result) ){
                        
                         
                          $TotalQuantity = $row['TotalQuantity'];

                      
                ?>
                <th>Total quantity</th>
                <td><?php echo $TotalQuantity; ?></td>
                <?php
                      }
                ?>
            </tr>
        </table>

                
    
    </div>

</body>
</html>