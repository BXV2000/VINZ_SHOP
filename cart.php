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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
      <?php include 'css/cart_test.css'; ?>
    </style>
    <title>VINZ - GIỎ HÀNG</title>
</head>
<body>
    <?php include 'login.php'; ?>
    <div class="cart_container">
        <div class="label_area">
            <h1>GIỎ HÀNG</h1>
        </div>
        <div class="detail_area">
            <table>
                <tr class="table_label">
                    <th class="delete_column"></th>
                    <th class="img_column"></th>
                    <th class="name_column" style='color:#342828'>Sản phẩm</th>
                    <th class="price_column" style='color:#342828'>Giá</th>
                    <th class="quantity_column" style='color:#342828'>Số lượng</th>
                    <th class="total_column" style='color:#342828'>Tổng tiền</th>
                </tr>
                
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
                            <input type="hidden" class="ten_sp_cart" value="<?php echo $row['ten_sp']; ?>">
                            <input type="hidden" class="id_sp_cart" value="<?php echo $row['id_sp']; ?>">  
                            <tr>
                                <td class="delete_column"><button type="submit" name='remove' class='item_remove'><i class="fas fa-times"></i></button></td>
                                <td class="img_column"><img src="img/<?php echo $row['hinh_anh']; ?>" alt="" class="item_img"></td>
                                <td class="name_column"><p class="item_name"><?php echo $row['ten_sp']; ?></p></td>
                                <td class="price_column"><p class="item_price"><?php echo $row['gia_sp']; ?></p></td>
                                <td class="quantity_column"><input type="number" class='item_quantity' name='quantity' value='1' ></td>
                                <td class="total_column"><input type="text" class='item_total' value="5000" disabled></td>
                            </tr>   
                            </form>
                        <?php 
                        $total = $total + (int)$row['gia_sp'];
                        }
                    }
                }

                ?>   
            </table>
        </div>
        <div class="bill_area">
            <form action="cart.php" id='hoa_don' method="post" class="bill_form">
                <label for="total_cost"><b>Tổng tiền</b><input type="text" name='total_cost' id="total_cost" value="" disabled></label>
                <input type="submit" name="checkout" id="" value="Thanh toán" class="check_out_button" >
            </form> 
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