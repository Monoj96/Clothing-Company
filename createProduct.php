<?php

//connect to database
$db=mysqli_connect("localhost","root","","business");

// Create Tables
    // CREATE TABLE product
    // (
    // productId int,
    // productName varchar(255),
    // productType varchar(255),
    // productPrice double,
    // productStatus int(1),
    // img longtext,
    // PRIMARY KEY(productId)
    // );

    // CREATE TABLE Orders
    // (
    // orderId int,
    // orderDate date,
    // orderTime time,
    // orderAmount double,
    // paymentType int(1),
    // primary key(orderId)
    // );
    // CREATE TABLE OrderDetails
    // (
    //     orderdetailsId int,
    //     orderId int,
    //     productId int,
    //     Quantity int,
    //     primary key(orderdetailsId)
    //     );
        




if(isset($_POST['create_btn']))
{
  

    $productName=mysqli_real_escape_string($db,$_POST['productName']);
    $productType=mysqli_real_escape_string($db,$_POST['productType']);
    $productPrice=mysqli_real_escape_string($db,$_POST['productPrice']);
    $productStatus = "0";

    $name = $_FILES['file']['name'];
    $target_dir = "imagesuploadedf/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
     
     // Valid file extensions
      $extensions_arr = array("jpg","jpeg","png","gif");

    if( in_array($imageFileType,$extensions_arr) ){
    
        $sql="INSERT INTO product (productName,  productType , productPrice, productStatus,img) VALUES('$productName', '$productType','$productPrice', '$productStatus','$name')"; 
        $sql_run = mysqli_query($db,$sql);

        if($sql_run){ 
   
            // $_SESSION["status"] = "The pproduct has been Added";
            // $_SESSION["status_code"] = "success";
          
            echo "done"; 
            // header("location:productList.php");
            // die();
        
            
         }else{
             echo "nope";
            // $_SESSION['status'] = "The product has not been Added";
            // $_SESSION['status_code'] = "error";
            // header("location:productList.php");
            // die();
        } 
        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
        // header("location:home.php");   
    }        
        
}

?>

<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <Style>
               *{
                font-family:Century Gothic;
               }
            </Style>       
           <title>Business</title>
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
        <h1>Create New Product</h1> 
        <form method="post" action="createProduct.php" enctype="multipart/form-data">
            <p><strong>Note: Please fill out this form to add a new product.</strong></p> 
            <div class="form">
                <table class="table table-bordered">
                    <tr>
                        <td>Product Name : </td>
                        <td><input type="text" name="productName" class="textInput" required></td>
                    </tr>
                    <tr>
                        <td>Product Type</td>
                        <td>
                            <select class="btn" name="productType" required>
                                <option value="">Select...</option>
                                <option value="Tee">Tee</option>
                                <option value="Polo">Polo</option>
                                <option value="Slides">Slides</option>
                                <option value="Cap">Cap</option>
                                <option value="Shorts">Shorts</option>
                                <option value="Bag">Bag</option>
                                <option value="Full Sleeve T-shirt">Full Sleeve T-shirt</option>
                                <option value="Shirts">Shirts</option>
                                <option value="Wallet">Wallet</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Product Price: </td>
                        <td><input type="text" name="productPrice" class="textInput" required></td>
                    </tr><br>
                    <tr>
                        <td>Upload image: </td>
                        <td> <input type='file' name='file' /></td>
                    </tr><br>
                    <tr>
                        <td></td>
                        <td><input class= "btn btn-success btn-lg btn-block" type="submit" name="create_btn" value='Create Product'></td>
                    </tr>
            </table>    
            </div>
        </form>
        </div>
    </body>
</html>