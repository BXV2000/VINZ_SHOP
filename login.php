<html>
    <head>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <style>
          
            <?php include 'css/login.css'; ?>
        </style>
    </head>
    <body>
    <div class="login_container">
      <div class="contact_area"> 
        <a href="index.php" ><img src="./img/logo.jpg" alt="Logo" /></a>
      </div>
      <div class="function_area">
        <a href="index.php" ><b>Trang chủ</b></a>
        <a href="shop.php" ><b>Cửa hàng</b></a>
        
        <a href="cart.php" ><i class="fas fa-shopping-cart">
        <span id="cart_number">
        <?php
        
        if(isset($_SESSION['cart'])){
          $count =count($_SESSION['cart']);
          echo"$count";
        }else echo 0;

        ?>
      </span></i>
      
      </a>
      </div>
    </div>
    </body>
</html>