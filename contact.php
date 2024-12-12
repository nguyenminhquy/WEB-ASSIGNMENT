<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>THỨC ĂN NHÀ MÌNH </title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="./user_view/assets/img/logo.jpg">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="./user_view/assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="./user_view/assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="./user_view/assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="./user_view/assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="./user_view/assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="./user_view/assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="./user_view/assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="./user_view/assets/css/responsive.css">
    <link rel="stylesheet" href="./assets/css/contact.css">

</head>
<body>
	

     <?php include './user_view/component/preloader.php'; ?>
	<!-- header -->
<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
					                    <!-- logo -->
										<div class="site-logo">
    <a href="shop_user.php">
        <img src="./user_view/assets/img/logo.jpg" alt="Logo">
    </a>
</div>

                    <!-- logo -->
                     <style>
                        .site-logo img {
    width: 100px; /* Đặt kích thước logo (có thể thay đổi tùy ý) */
    height: 100px; /* Đảm bảo chiều cao và chiều rộng đều nhau */
    border-radius: 50%; /* Chuyển logo thành hình tròn */
    object-fit: cover; /* Đảm bảo hình ảnh không bị méo khi thay đổi kích thước */
}

                     </style>

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="index.php">TRANG CHỦ </a></li>
								<li><a href="./about.php">GIỚI THIỆU </a></li>
                                <li><a href="./contact.php">THÔNG TIN LIÊN HỆ  </a></li>
                                <li><a href="../user_view/pages/login.php">ĐĂNG NHẬP   </a></li>
                                <li><a href="../user_view/pages/register.php">ĐĂNG KÍ   </a></li>
								
								<li>
									<div class="header-icons">
										<a class="shopping-cart" href="./user_view/pages/login.php"><i class="fas fa-shopping-cart"></i></a>
										<a class="mobile-hide search-bar-icon" href="./user_view/pages/login.php"><i class="fas fa-search"></i></a>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<?php include './user_view/component/hero_area.php'; ?>
    <div class="container2">
    <h1>Thông tin liên lạc - Cửa Hàng</h1>
    
    <div class="contact-info">
        <h2>Thông tin cửa hàng:</h2>
        <p><i class="fas fa-map-marker-alt"></i> <strong>Địa chỉ:</strong> 123 Đường XYZ, Quận ABC, Thành phố HCM</p>
        <p><i class="fas fa-phone"></i> <strong>Số điện thoại:</strong> (028) 1234 5678</p>
        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> lienhe@cua-hang.com</p>
        <p><i class="fas fa-clock"></i> <strong>Giờ mở cửa:</strong> 9:00 AM - 6:00 PM (Tất cả các ngày trong tuần)</p>
    </div>
    
    <!-- Form liên hệ -->
    <div class="contact-form">
        <h2>Liên hệ với chúng tôi</h2>
        <form action="submit_contact_form.php" method="POST">
            <input type="text" name="name" placeholder="Tên của bạn" required>
            <input type="email" name="email" placeholder="Email của bạn" required>
            <textarea name="message" placeholder="Lời nhắn của bạn" rows="4" required></textarea>
            <button type="submit"><i class="fas fa-paper-plane"></i> Gửi thông tin</button>
        </form>
    </div>
</div>

   
	
	<?php include './user_view/component/footer.php'; ?>

	
	
	
	
	<!-- jquery -->
	<script src="./user_view/assets/js/jquery-1.11.3.min.js"></script>
	
	<!-- bootstrap -->
	<script src="./user_view/assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="./user_view/assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="./user_view/assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="./user_view/assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="./user_view/assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="./user_view/assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="./user_view/assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="./user_view/assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="./user_view/assets/js/main.js"></script>

</body>
</html>