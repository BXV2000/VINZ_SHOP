<?php
include('connection.php');

if(isset($_POST['checkout']))
{
    $get_max_id = "SELECT MAX(id_hoa_don) AS max_id FROM lich_su;"
    $row = mysql_fetch_array( $get_max_id );
    $largestNumber = $row['max'];
    $so_luong_sp=$_POST['item_number'];
    print_r($largestNumber);
    // for($i=0;$i<$so_luong_sp;$i++)
    // {   
    //     $id_sp = $_POST["id_sp_$i"];
    //     $ten_sp = $_POST["ten_sp_$i"];
    //     $sl_sp = $_POST["soluong_$i"];
    //     $query="INSERT INTO hoa_don (id_sp,ten_sp,so_luong)
    //     VALUES (' $id_sp','$ten_sp','$sl_sp');";
    //     $statement = $connect->prepare($query);
    //     $statement->execute();
    // }
    
}

?>