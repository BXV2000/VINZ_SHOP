<?php

session_start();
include('connection.php');
require_once("component.php");

if(isset($_POST['remove'])){
    if($_GET['action']=='remove'){
        foreach($_SESSION['cart']as $key=>$value){
            if($value['id_sp']==$_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo"<script>alert(`Đã bỏ hàng khỏi giỏ`)</script>";
                echo"<script>window.location='cart.php' </script>";
            }
        }
    }
}

// if(isset($_POST['checkout']))
// {
//     $get_max_id_hd = "SELECT MAX(id_hoa_don) AS max_id_hd FROM lich_su;";
//     $statement_get = $connect->prepare($get_max_id_hd);
//     $statement_get->execute();
//     $row = $statement_get -> fetch(PDO::FETCH_ASSOC);
//     $id_hd = $row['max_id_hd']+1;
//     $get_max_id_kh = "SELECT MAX(id_khach_hang) AS max_id_kh FROM lich_su;";
//     $statement_get = $connect->prepare($get_max_id_kh);
//     $statement_get->execute();
//     $row = $statement_get -> fetch(PDO::FETCH_ASSOC);
//     $id_kh = $row['max_id_kh']+1;
//     $so_luong_sp=$_POST['item_number'];
//     $tong_tien = $_POST['total_cost'];
//     // print_r($id_hd);
//     for($i=0;$i<$so_luong_sp;$i++)
//     {   
//         $id_sp = $_POST["id_sp_$i"];
//         $sl_sp = $_POST["soluong_$i"];
//         $query="INSERT INTO hoa_don (id_hoa_don,id_sp,so_luong)
//         VALUES ('$id_hd',' $id_sp','$sl_sp');";
//         $statement = $connect->prepare($query);
//         $statement->execute();
//     }
//     $final = "INSERT INTO `lich_su`(`id_hoa_don`, `id_khach_hang`, `tong_tien`) VALUES ('$id_hd','$id_kh','$tong_tien')";
//     $statement = $connect->prepare($final);
//     $statement->execute();
// }

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
         <?php include 'css/cart.css'; ?>
    </style>
    <title></title>
</head>
<body>
<?php include 'login.php'; ?>
    <?php include 'navbar.php'; ?>
    <div class="cart_container">

        <div class="item_area">
            <?php
            $query = "SELECT * FROM san_pham WHERE tinh_trang = '1'";
            $product_id=array_column($_SESSION['cart'],'id_sp');
            $statement = $connect->prepare($query);
	        $statement->execute();
            $total=0;
            $result = $statement->fetchAll();
            foreach($result as $row) {
                foreach($product_id as $id){
                    if($row['id_sp'] == $id){
                        ?>
                        <form action="cart.php?action=remove&id=<?php echo $row['id_sp']; ?>" method="post" class="item">
                        <div class="item_info">
                            <img src="img/<?php echo $row['hinh_anh']; ?>" alt="">
                            <div class='item_info_detail'>
                            <p class='item_name'><?php echo $row['ten_sp']; ?></p>
                            <p class='item_price'><?php echo $row['gia_sp']; ?></p>
                            </div>
                        </div>

                        <div class="item_buttons">
                            <input type="submit" name='remove' value="xoa">
                            <input type="submit" value="save">
                            <input type="hidden" class="ten_sp_cart" value="<?php echo $row['ten_sp']; ?>">
                            <input type="hidden" class="id_sp_cart" value="<?php echo $row['id_sp']; ?>">  
                            <input type="number" class='quantity' name='quantity' value='1' >
                        </div>
                    </form>
                    <?php 
                    $total = $total + (int)$row['gia_sp'];
                    }
                }
            }

            ?>
            
        </div>

        <div class="user_area">
            <div class="price_section">
                <form action="cart.php" id='hoa_don' method="post">

                <input type="text" name='total_cost' id="total_cost" value="" disabled>
                <input type="submit" name="checkout" id="" value="Thanh toán" >
                </form> 
            </div>
            <div class="form_section"> 
                <h2>Họ tên</h2>
            </div>
        </div>
    </div>
    
    <script>
       
        
        function themHoaDon(){
            let items = document.getElementsByClassName('item');
            let id_items = document.getElementsByClassName('id_sp_cart');
            let name_items = document.getElementsByClassName('ten_sp_cart');
            let quantity_items =document.getElementsByClassName('quantity');
            document.getElementById("hoa_don").innerHTML += `<input type="hidden" name="item_number" value="${items.length}">`;
            for(let i = 0;i<items.length;i++){
            document.getElementById("hoa_don").innerHTML += 
              `<input type="hidden" name="id_sp_${i}" value="${id_items[i].value}">
                <input type="hidden" name="ten_sp_${i}" value="${name_items[i].value}">
                <input type="hidden" name="soluong_${i}" class="checkout_quantity" value="${quantity_items[i].value}">`;
            }
        }
        
        function kt_so_luong(ds_so_luong){
            let items = document.getElementsByClassName('item');
            if (ds_so_luong.length===0){
                let items = document.getElementsByClassName('item');
                for(let i = 0;i<items.length;i++){
                    ds_so_luong.push(1);
                }
                
            }
        }

        function tinhTienBanDau(){
            let tong_tien=0;
            let item_price = document.getElementsByClassName('item_price');
            for(let i = 0;i<ds_so_luong.length;i++){
                tong_tien+= parseInt(item_price[i].innerHTML)*ds_so_luong[i];
            }
            document.getElementById('total_cost').value=tong_tien;
            console.log(document.getElementById('total_cost').value)
        }

        function tinhTien(){
            let items = document.getElementsByClassName('item');
            let quantity =document.getElementsByClassName('quantity');
            let item_price = document.getElementsByClassName('item_price');
            let item_quantity = document.getElementsByClassName('checkout_quantity');
            for(let i = 0;i<items.length;i++){
                quantity[i].addEventListener("change", function () {
                    ds_so_luong[i]=parseInt(quantity[i].value);
                    tinhTienBanDau();
                    item_quantity[i].value=quantity[i].value;
                    console.log(item_quantity[i].value)
                });
            }
        }
        let ds_so_luong=[];
        kt_so_luong(ds_so_luong);
        tinhTienBanDau();
        tinhTien();
        themHoaDon();
    </script>
</body>
</html>