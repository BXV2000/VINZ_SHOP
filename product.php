<?php

session_start();

include('connection.php');
 
if(isset($_POST['add'])){
  
    if(isset($_SESSION['cart'])){
      $item_array_id=array_column($_SESSION['cart'],'MSHH');
  
      if(in_array($_POST['id'],$item_array_id)){
          echo"<script>alert(`Hàng đã nằm trong giỏ`)</script>";
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
  $query_product = "SELECT hanghoa.MSHH,hanghoa.QuyCach, hanghoa.TenHH,hanghoa.Gia,loaihanghoa.TenLoaiHang,hinhhanghoa.TenHinh,hanghoa.MaLoaiHang    
                     FROM hanghoa 
                     JOIN loaihanghoa ON hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang
                     JOIN hinhhanghoa  ON hinhhanghoa.MSHH = hanghoa.MSHH
                     WHERE hanghoa.MSHH=".$_GET['id'];

    $result_product = mysqli_query($connect,$query_product);
    $product=mysqli_fetch_assoc($result_product);
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
    <?php include 'css/product.css'; ?>
    </style>
    <title>VINZ - <?php echo $product['TenHH']?></title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="shop_container">
        <div class="shop_area">
            <div class="item_area">
                <div class="item_top">
                    <img src="./img/<?php echo $product['TenHinh']?>" alt="" class="item_img">
                    <div class="item_detail_top">
                        <h2><?php echo $product['TenHH']?></h2>
                        <h2><?php echo $product['Gia']?>&nbspVNĐ</h2>
                        <p><?php echo $product['QuyCach']?></p>
                        <form method="post" class="" action="/B1805937_BXVINH/GUEST/product.php?id=<?php echo $product['MSHH']?>">
                            <input type="hidden" name="id" value="<?php echo $product['MSHH']?>">
                            <input type="hidden" name="name" value="<?php echo $product['TenHH']?>">
                            <input type="hidden"  name="price" value="<?php echo $product['Gia']?>">
                            <input class="basic_button" type="submit" name="add" value="Thêm vào giỏ">
                        </form>  
                        <p>Loại sản phẩm: <a href="./category_shop.php?id=<?php echo $product['MaLoaiHang']?>" target="_blank" class="item_tag"><?php echo $product['TenLoaiHang']?></a></p>

                    </div>
                </div>
                <div class="item_bottom">
                    <h3 class="item_bottom_label"><b>Thông tin sản phẩm</b></h3>
                    <hr>
                    <p class="item_bottom_detail">Morbi non accumsan libero, volutpat ullamcorper odio. Donec non libero id augue suscipit commodo. Curabitur porta ac ligula vel sollicitudin. Praesent vestibulum tellus urna, in imperdiet neque lobortis eleifend. Nunc eros nulla, porta quis urna nec, luctus viverra diam. In ut ante est. Duis venenatis erat ac nisl malesuada gravida. Pellentesque pellentesque tempor urna, quis vehicula mi mollis hendrerit. Etiam iaculis convallis arcu, id lacinia massa imperdiet vitae.

                    Nam accumsan a augue ut lobortis. Ut ac libero vel libero consectetur dictum ac in ante. Pellentesque efficitur nibh id condimentum blandit. Phasellus vulputate, tellus in vestibulum feugiat, felis nisl pulvinar mi, mollis eleifend orci risus sit amet orci. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas vitae viverra risus. Vivamus eget accumsan elit, tincidunt pharetra orci. Maecenas neque mi, porttitor eu ullamcorper nec, aliquet eu nulla. Mauris maximus turpis tellus, vel aliquam neque aliquet accumsan. Maecenas ultrices facilisis libero, eu laoreet mauris. Integer non aliquam sapien, ut auctor sem. Vivamus urna urna, eleifend eget augue sed, pulvinar rutrum enim. Nullam lacinia mauris vel mattis lacinia.</p>
                    <hr>
                    <h2>Các sản phẩm khác</h2>
                    <div class="products">
                    <?php  
                    $query = 'SELECT hanghoa.MSHH, hanghoa.TenHH,hanghoa.Gia,loaihanghoa.TenLoaiHang,hinhhanghoa.TenHinh ,hanghoa.MaLoaiHang  
                     FROM hanghoa 
                     JOIN loaihanghoa ON hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang
                     JOIN hinhhanghoa  ON hinhhanghoa.MSHH = hanghoa.MSHH
                     WHERE SoLuongHang > "0" AND hanghoa.MSHH != '.$product['MSHH'].'
                     ORDER BY tenHH ASC
                     LIMIT 3';
                    $result = mysqli_query($connect,$query);
                    mysqli_fetch_all($result,MYSQLI_ASSOC);
                    $rowcount=mysqli_num_rows($result);
                    if($rowcount > 0)
	                {
		                foreach($result as $row)
		                {
                        ?>
                            <form method="post" class="product" action="./product.php?id=<?php echo $product['MSHH']?>">
                                <a href="./product.php?id=<?php echo $row['MSHH']?>"  target="_blank"   ><img src="./img/<?php echo $row['TenHinh']?>" alt="" class="product_img"></a>
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
            </div>
            <div class="sidebar">
                <div class="sorting_label">
                    <h2 class="area_label_text"><b>Danh mục sản phẩm</b></h2>
                </div>
                <div class="sort_categories">
                    <?php
                        $query_sorting = 'SELECT * from loaihanghoa ORDER BY TenLoaiHang ASC' ;
                        $result_sorting = mysqli_query($connect,$query_sorting);
                        mysqli_fetch_all($result_sorting,MYSQLI_ASSOC);
                        $row_sorting_count=mysqli_num_rows($result);
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