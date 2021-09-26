<?php

session_start();

?>
<html>
  <head>
    <title>VINZ - TRANG CHỦ</title>
    <style>
      <?php include 'css/index.css'; ?>
    </style>
  </head>
  <body>
  <?php include 'login.php'; ?>
  <div class="index_container">
    <div class="header_area">
      <h1>Nơi sản phẩm luôn tươi sạch và chất lượng</h1>
      <p>Hãy đến với chúng tôi</p>
      <div class="header_buttons">
        <a href="shop.php" class="header_order_button"><b>Đặt hàng ngay</b></a>
        <a href="#reason" class="header_explore_button"><b>Khám phá</b></a>
      </div>
    </div>
    <div class="reason_area" id="reason">
      <div class="reason_area_label">
        <h1>Lựa chọn đúng đắn</h1>
      </div>
      <div class="reason_area_contents">    
        <div class="reason_content" style="background-color:#FE2F41">
          <img src="./img/reason_content_1.jpg" alt="">
          <div class="reason_text">
          <h2>Phục vụ tận tâm</h2>
          <p>Chúng tôi đem lại dịch vụ bằng cả sự tâm huyết và nhiệt tình.</p>
          <a href="" class="reason_button" style="color:#FE2F41"><b>Tìm hiểu</b></a>
          </div>
        </div>
        <div class="reason_content" style="background-color:#FCAE03">
          <img src="./img/reason_content_2.jpg" alt="">
          <div class="reason_text">
          <h2>Sản phẩm chất lượng</h2>
          <p>Luôn đem lại các sản phẩm đến từ các thương hiệu uy tín.</p>
          <a href="shop.php" class="reason_button" style="color:#FCAE03"><b>Mua ngay</b></a>
          </div>
        </div>
        <div class="reason_content" style="background-color:#A0918A">
          <img src="./img/reason_content_3.jpg" alt="">
          <div class="reason_text">
          <h2>Uy tín tuyệt đối</h2>
          <p>Sự ưu tiên của khách hàng luôn là mục tiêu hoạt động của chúng tôi.</p>
          <a href="" class="reason_button" style="color:#A0918A"><b>Liên hệ ngay</b></a>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <?php include 'footer.php'; ?>
  </body>
</html>
