<?php

function cartElement($hinh_anh,$ten_sp,$gia_sp){
    $element=`
    <form action="cart.php" method="get" class="item">
                <div class="item_info">
                    <img src="img/$hinh_anh" alt="">
                    <div class='item_info_detail'>
                    <p>$ten_sp</p>
                    <p>$gia_sp</p>
                    </div>
                </div>

                <div class="item_buttons">
                    <input type="submit" name='remove' value="xoa">
                    <input type="submit" value="save">
                    <input type="number" value='1' >
                </div>
            </form>
    `;
    echo $element;
}

?>