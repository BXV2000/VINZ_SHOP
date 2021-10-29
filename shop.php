<?php

session_start();
include('connection.php');
 
global $product_name;

if(isset($_POST['add'])){
  
    if(isset($_SESSION['cart'])){
      $item_array_id=array_column($_SESSION['cart'],'MSHH');
  
      if(in_array($_POST['id'],$item_array_id)){
          echo"<script>alert(`Hàng đã nằm trong giỏ`)</script>";
          echo"<script>window.location='shop.php' </script>";
      }else{
        $count = count($_SESSION['cart']);
        $item_array=array(
          'MSHH'=>$_POST['id']
        );
        $_SESSION['cart'][$count] = $item_array;
      }
    }
    else
    {
      $item_array=array(
        'MSHH'=>$_POST['id']
      );
      $_SESSION['cart'][0]=$item_array;

    }
  }

  if(isset($_GET['search_product'])){
    $product_name="";
     $product_name=$_GET['product_name_input'];
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    <?php include 'css/shop.css'; ?>
    </style>
    <title>VINZ - CƯA HÀNG</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="shop_container">
        <div class="label_area">
            <h1>CỬA HÀNG</h1>
        </div>
        <div class="shop_area">
            <div class="product_area">
                <div class="products">
                    <?php  
                    $query_product_name="";
                    if($product_name!='0'&&$product_name!=null){
                        $query_product_name =" AND hanghoa.TenHH LIKE'%$product_name%'";
                    }
                    $query = 'SELECT hanghoa.MSHH, hanghoa.TenHH,hanghoa.Gia,loaihanghoa.TenLoaiHang,hinhhanghoa.TenHinh,hanghoa.MaLoaiHang    
                     FROM hanghoa 
                     JOIN loaihanghoa ON hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang
                     JOIN hinhhanghoa  ON hinhhanghoa.MSHH = hanghoa.MSHH
                     WHERE SoLuongHang > "0" '.$query_product_name.' 
                     ORDER BY tenHH ASC' ;
                    $result = mysqli_query($connect,$query);
                    mysqli_fetch_all($result,MYSQLI_ASSOC);
                    $rowcount=mysqli_num_rows($result);
                    if($rowcount > 0)
	                {
		                foreach($result as $row)
		                {
                        ?>
                            <form method="post" class="product" action="shop.php">
                                <a href="./product.php?id=<?php echo $row['MSHH']?>"target="_blank"><img src="./img/<?php echo $row['TenHinh']?>"  alt="" class="product_img"></a>
                                <input type="hidden" name="id" value="<?php echo $row['MSHH']?>">
                                <input type="hidden" name="name" value="<?php echo $row['TenHH']?>">
                                <input type="hidden"  name="price" value="<?php echo $row['Gia']?>">
                                <a href="./product.php?id=<?php echo $row['MSHH']?>" class="product_name" target="_blank"><?php echo $row['TenHH']?></a>
                                <a href="./category_shop.php?id=<?php echo $row['MaLoaiHang']?>" class = "product_tag" target="_blank"><?php echo $row['TenLoaiHang']?></a>
                                <h3 class="product_price"><?php echo $row['Gia']?> VNĐ</h3>
                                <input class="product_add" type="submit" name="add" value="Thêm vào giỏ">
                            </form>   
                        <?php
                        }
                    }
                    else
                    {
                        echo '<h3>No data found</h3>';
                    }
                    ?>
                </div>
            </div>
            <div class="sidebar">
                <div class="sorting_label">
                    <h2 class="area_label_text">Tìm kiếm sản phẩm</h2>
                </div>
                <form action="shop.php" method="GET" class="product_search_form">
                    <input type="text" class="search_product_input" name="product_name_input">
                    <button type="submit" name="search_product" class='search_product_btn'><i class="fas fa-search"></i></button>
                </form>
                <div class="sorting_label">
                    <h2 class="area_label_text">Danh mục sản phẩm</h2>
                </div>
                <div class="sort_categories">
                    <?php
                        $query_sorting = 'SELECT * from loaihanghoa ORDER BY TenLoaiHang ASC' ;
                        $result_sorting = mysqli_query($connect,$query_sorting);
                        mysqli_fetch_all($result_sorting,MYSQLI_ASSOC);
                        $row_sorting_count=mysqli_num_rows($result_sorting);
                        if($row_sorting_count > 0){
                            foreach($result_sorting as $row_sorting){?>
                                <a href="./category_shop.php?id=<?php echo $row_sorting['MaLoaiHang']?>" target="_blank" class="sort_category"><?php echo $row_sorting['TenLoaiHang']?></a>
                            <?php
                            }
                        }

                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
    </script>
</body>
</html>