<?php

//connect to database
$db=mysqli_connect("localhost","root","","business");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <title>Product List</title>
</head>
<body>
    <div class="panel-heading">
        <h1>Search for anyProducts</h1>
    </div> 

     <!-- implementing search engine        -->
        <div id="wrapper">
            <div id="search_box">
                <form method="post"action="searchProduct.php" onsubmit="return do_search();">
                    <div class="container h-100">
                        <div class="d-flex justify-content-center h-100">
                            <div class="searchbar">
                                <input type="text" id="search_term"  class="search_input" name="search_term" placeholder="Please enter the user name or the pet name" onkeyup="do_search();">   
            
                                    <button  type="submit" class ="search_icon"  name="search"> <i class="fas fa-search"></i></button><hr>
            
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="result_div"></div>
        </div>
        <?php 
           if(isset($_POST['search']))
           {
             
            $search_val = mysqli_real_escape_string($db,$_POST['search_term']);

            $get_result = "SELECT * FROM product WHERE  (productType LIKE ('%$search_val%') OR  productName LIKE ('%$search_val%')) AND productStatus = '0'";
           
            $result = mysqli_query($db,$get_result) or die( mysqli_error($db));
            
            while($row = mysqli_fetch_array($result) ){
                $productId = $row['productId'];
                $productName = $row['productName'];
                $productType = $row['productType'];
                $img = $row['img'];
                $image_src = "imagesuploadedf/".$img;
            ?> 
            <div class="">
                    <img class="img-thumbnail" style="width:200px;" alt="Responsive image" src='<?php echo $image_src;  ?>' >
                    <h4><strong>Product Name:</strong> <?= $productName ?></h4>
                    <p><strong>Product Type:</strong><?= $productType ?></p>
                    <!-- select products -->
                    <form method="POST" action="salesDraft.php">
                        <input type="hidden" name="productName" value='<?= $productName ?>'>
                        <input type="hidden" name="productType" value='<?= $productType ?>'>
        
                        <input type='checkbox'  name='select[]' value='<?= $productId?>' >
                        
                  
            </div>
        <?php
                    }
            }    
        ?>  
        
        <input class= "btn btn-outline-danger btn-block" type='submit' value='Selected' name='btn_selected'><br><br>
        </form>    
  </div>

<!-- Shows all products -->
<?php

$query = "SELECT * FROM product";
$result = mysqli_query($db,$query);

while($row = mysqli_fetch_array($result) ){
    //   $u = $row['user'];
    $productName = $row['productName'];
    $productType = $row['productType'];
    $productPrice = $row['productPrice'];
    $img = $row['img'];
    $image_src = "imagesuploadedf/".$img;
?>
    <div class="">
        <div class="panel panel-default text-center">
              
            <div class="panel-body">
                <img class="img-thumbnail" style="width:200px;" alt="Responsive image" src='<?php echo $image_src;  ?>' >
                <h4><strong>Product Name:</strong> <?= $productName ?></h4>
                <p><strong>Product Type:</strong> <?= $productType ?></p>
                <p><strong>Price:</strong> $<?= $productPrice ?>AUD</p>
            </div><hr>
        </div>
    </div>
<?php
      }
?>


<script type="text/javascript">
            function do_search()
            {
                var search_term=$("#search_term").val();
                $.ajax
                ({
                type:'post',
                url:'searchProduct.php',
                data:{
                search:"search",
                search_term:search_term
                },
                success:function(response) 
                {
                document.getElementById("result_div").innerHTML=response;
                }
                });
            
            return false;
            }
</script>      


</body>
</html>