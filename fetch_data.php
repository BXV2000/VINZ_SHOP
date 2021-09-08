<?php

include('connection.php');

if(isset($_POST["action"]))
{
    $query = "SELECT * FROM san_pham WHERE tinh_trang = '1'";

    
    if(isset($_POST["tag"]))
	{
		$brand_filter = implode("','", $_POST["tag"]);
		$query .= "
		 AND loai_sp IN('".$brand_filter."')
		";
	}
    $query .=" ORDER BY ten_sp ASC";
    $statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
            <form method="post" class="product" action="shop.php">
                <img src="./img/'.$row['hinh_anh'].'" alt="" class="product_img">
                <input type="hidden" name="id" value="'.$row['id_sp'].'">
                <input type="hidden" name="name" value="'.$row['ten_sp'].'">
                <input type="hidden"  name="price" value="'.$row['gia_sp'].'">
                <h3 class="product_name">'. $row['ten_sp'] .'</h3>
                <p class = "product_tag">'. $row['loai_sp'] .'</p>
                <h3 class="product_price">'. $row['gia_sp'] .' VNĐ</h3>
                <input class="product_add" type="submit" name="add" value="Thêm vào giỏ">
            </form>
            ';
        }
    }
    else {
        $output= '<h3>No data found</h3>';
    }
    echo $output;
}

?>