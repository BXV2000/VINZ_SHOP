<?php

session_start();

include('connection.php');

if(isset($_POST['add'])){
  
    if(isset($_SESSION['cart'])){
      $item_array_id=array_column($_SESSION['cart'],'id_sp');
  
      if(in_array($_POST['id'],$item_array_id)){
          echo"<script>alert(`Hàng đã nằm trong giỏ`)</script>";
          echo"<script>window.location='shop.php' </script>";
      }else{
        $count = count($_SESSION['cart']);
        $item_array=array(
          'id_sp'=>$_POST['id']
        );
  
        $_SESSION['cart'][$count] = $item_array;
  
      }
    }
    else
    {
      $item_array=array(
        'id_sp'=>$_POST['id']
      );
      $_SESSION['cart'][0]=$item_array;

    }
  }
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <style>
    <?php include 'css/shop.css'; ?>
    </style>
    <title>VINZ - SHOP</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="shop_container">
        <div class="label_area">
            <h1>SHOP</h1>
        </div>
        <div class="shop_area">
            <div class="product_area">
                <div class="products"></div>
            </div>
            <div class="sorting_area">
            <h2><b>Danh mục sản phẩm</b></h2>
            <?php
                $query = "SELECT DISTINCT(loai_sp) FROM san_pham WHERE tinh_trang = '1' ORDER BY id_sp DESC";
                $statement = $connect->prepare($query);
                $statement ->execute();
                $result = $statement->fetchAll();
                foreach($result as $row) {
                ?>
                <label for="" class="tags"><?php echo $row['loai_sp']?> <input type="checkbox" class="pick tag" value="<?php echo $row['loai_sp']; ?>" > </label>
                <?php
            }
            ?>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() 
        {
            filter_data();

            function filter_data() 
            {
                $('.products');
                var action = 'fetch_data';
                var tag = get_filter('tag');
                $.ajax({
                    url: "fetch_data.php",
                    method: "POST",
                    data: {action: action,tag:tag},
                    success: function(data) {
                        $('.products').html(data);
                    }
                });
            }

            function get_filter(class_name)
            {
                var filter = [];
                $('.'+class_name+':checked').each(function(){
                    filter.push($(this).val());
                });
                return filter;
            }

            $('.pick').click(function() {
                filter_data();
            });


        });
    </script>
</body>
</html>