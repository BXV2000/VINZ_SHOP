<?php

session_start();

include('connection.php');

if(isset($_POST['add'])){
  // print_r($_POST['id']);

  if(isset($_SESSION['cart'])){
    $item_array_id=array_column($_SESSION['cart'],'id_sp');
    print_r($item_array_id);
    // print_r($_SESSION['cart']);

    if(in_array($_POST['id'],$item_array_id)){
        echo"<script>alert(`Hàng đã nằm trong giỏ`)</script>";
        echo"<script>window.location='shop.php' </script>";
    }else{
      $count = count($_SESSION['cart']);
      $item_array=array(
        'id_sp'=>$_POST['id']
      );

      $_SESSION['cart'][$count] = $item_array;
      print_r( $_SESSION['cart']);

    }
  }
  else
  {
    $item_array=array(
      'id_sp'=>$_POST['id']
    );
    $_SESSION['cart'][0]=$item_array;
    // print_r($_SESSION['cart']);
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
  <title>Document</title>
</head>
<body>
<?php include 'login.php'; ?>
    <div class="shop_container">
      <div class="product_area">
        <div class="product_area_left">
          <div class="side_bar">
            <h2>Danh mục sản phẩm</h2>
            <?php
            $query = "SELECT DISTINCT(loai_sp) FROM san_pham WHERE tinh_trang = '1' ORDER BY id_sp DESC";
            $statement = $connect->prepare($query);
            $statement ->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
            ?>
            <div class="product_tag">
              <label for=""><input type="checkbox" class="pick tag" value="<?php echo $row['loai_sp']; ?>" > <?php echo $row['loai_sp']?></label>
              </div>
              <?php
          }
          ?>
            </div>
          
          <div class="cart">
            <h2>Giỏ hàng</h2>
            <?php
            

            ?>
          </div>
        </div>
        <div class="product_area_right">
          <div class="top_sort">
            <button class="page_button" id="to_first"><<</button>
            <button class="page_button" id="back"><</button>
            <button class="page_indicator" id="">1</button>
            <button class="page_button" id="next">></button>
            <button class="page_button" id="to_last">>></button>
          </div>
          <div class="products">
            
          </div>
          
          <div class="bottom_sort">
            <button class="page_button" id="to_first"><<</button>
            <button class="page_button" id="back"><</button>
            <button class="page_indicator" id="">1</button>
            <button class="page_button" id="next">></button>
            <button class="page_button" id="to_last">>></button>
          </div>
        </div>
      </div>
      <div class="other_area"><h2>Tin tức</h2></div>
    </div>
    <style>

</style>
    <script>
      $(document).ready(function() {

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

