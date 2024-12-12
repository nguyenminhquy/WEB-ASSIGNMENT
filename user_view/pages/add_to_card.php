<?php
session_start();

$message = ''; 
if (!isset($_SESSION['user_id'])) {
    $message = "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!";
    exit();
}

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $message = "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error;
    exit();
}

$sql_check = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param('ii', $user_id, $product_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $sql_update = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('iii', $quantity, $user_id, $product_id);
    $stmt_update->execute();
    $message = "Sản phẩm đã được thêm vào giỏ hàng!";
    $stmt_update->close();
} else {
    $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('iii', $user_id, $product_id, $quantity);
    $stmt_insert->execute();
    $message = "Sản phẩm đã được thêm vào giỏ hàng!";
    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>

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
	<link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="../assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="../assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="../assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="../assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="../assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="../assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/addtocard.css">
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">


</head>
<body>
   <!-- header -->
<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- logo -->
                    <div class="site-logo">
    <a href="shop_user.php">
        <img src="../assets/img/logo.jpg" alt="Logo">
    </a>
</div>

             

                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li class="current-list-item"><a href="./index.php">TRANG CHỦ</a></li>
                          

                            <!-- Đoạn PHP để hiển thị tên người dùng hoặc đăng nhập -->
                            <?php
                            if (isset($_SESSION['username'])) {
                                // Nếu đã đăng nhập, hiển thị tên người dùng thay vì "Profile"
                                $username = $_SESSION['username'];
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="./profile.php">
                                            <i class="bi bi-person-circle"></i> ' . htmlspecialchars($username) . '
                                        </a>
                                      </li>';
                                // Hiển thị nút Đăng xuất
                                echo '<li><a href="logout.php">ĐĂNG XUẤT</a></li>';
                            } else {
                                // Nếu chưa đăng nhập, hiển thị liên kết "Đăng nhập" và "Đăng kí"
                                echo '<li><a href="./login.php">ĐĂNG NHẬP</a></li>';
                                echo '<li><a href="./register.php">ĐĂNG KÍ</a></li>';
                            }
                            ?>

                            <li>
                                <div class="header-icons">
                                    <a class="shopping-cart" href="./cart.php"><i class="fas fa-shopping-cart"></i></a>
                                    <a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
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
 <!-- hero area -->
<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle">THỨC ĂN HẤP DẪN </p>
							<h1>HÃY KIỂM TRA GIỎ HÀNG CỦA BẠN NÀO ! </h1>
							<div class="hero-btns">
								<a href="./shop_user.php" class="boxed-btn">MUA NGAY THÔI </a>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->






<!-- Hero Area -->
<div class="hero-area hero-bg">
    <div class="container">
        <div class="container my-5">
            <div class="box-container p-5 rounded shadow-lg bg-light">

                <div class="text-center mt-3">
                    <p class="lead display-4">Khám phá thêm các sản phẩm tuyệt vời ngay bây giờ!</p>
                    <a href="./shop_user.php" class="btn btn-dark btn-lg animated fadeInUp" role="button">
                        <i class="fa fa-arrow-right"></i> TIẾP TỤC MUA SẮM 
                    </a>
                </div> 
<?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show my-3 animate__animated animate__fadeInUp" role="alert">
        <?= htmlspecialchars($message); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="text-center mt-4 d-flex justify-content-center align-items-stretch">
    <a href="./shop_user.php" class="btn btn-primary btn-lg mx-3 my-3 flex-fill" role="button">
        <i class="fa fa-shopping-cart"></i> Tiếp Tục Mua Hàng
    </a>
    
    <a href="./cart.php" class="btn btn-warning btn-lg mx-3 my-3 flex-fill" role="button">
        <i class="fa fa-cart-plus"></i> Xem Giỏ Hàng
    </a>

    <a href="contact.php" class="btn btn-info btn-lg mx-3 my-3 flex-fill" role="button">
        <i class="fa fa-headset"></i> Liên Hệ Hỗ Trợ
    </a>

    <a href="promo.php" class="btn btn-success btn-lg mx-3 my-3 flex-fill" role="button">
        <i class="fa fa-gift"></i> Khuyến Mãi Hấp Dẫn
    </a>
</div>

            </div> <!-- End of Box Container -->

        </div>
    </div>
</div>

    <?php include '../component/footer.php'; ?>
   
<script>
    $('.alert .close').on('click', function() {
        $(this).parent('.alert').addClass('animate__fadeOut').fadeOut(500);
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

