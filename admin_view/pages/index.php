<?php
// Bắt đầu phiên làm việc (session)
session_start();

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Thay đổi nếu cần
$password = "";      // Thay đổi nếu cần
$dbname = "food_web"; // Thay đổi tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy tổng số sản phẩm
$sql_products = "SELECT COUNT(*) AS total_products FROM products";
$result_products = $conn->query($sql_products);
$total_products = ($result_products->num_rows > 0) ? $result_products->fetch_assoc()['total_products'] : 0;

// Lấy tổng doanh thu
$sql_sales = "SELECT SUM(price) AS total_sales FROM products";
$result_sales = $conn->query($sql_sales);
$total_sales = ($result_sales->num_rows > 0) ? $result_sales->fetch_assoc()['total_sales'] : 0;

// Lấy user_id từ session (nếu người dùng đã đăng nhập)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


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
	<link rel="shortcut icon" type="image/png" href="./user_view/assets/img/logo.jpg">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="../../user_view/assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="../../user_view/assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="../../user_view/assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="../../user_view/assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="../../user_view/assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="../../user_view/assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="../../user_view/assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="../../user_view/assets/css/responsive.css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Thêm Bootstrap JS và jQuery (để đóng alert) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        <img src="../../user_view/assets/img/logo.jpg" alt="Logo">
    </a>
</div>







						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="./index.php">TRANG CHỦ </a></li>
								<li><a href="./user_view/pages/login.php">GIỚI THIỆU </a></li>
                                <li><a href="about.php">THÔNG TIN LIÊN HỆ  </a></li>
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


<!-- HERO AREA  CHỈ CẦN COPY VO TỪNG TRANG LÀ DC -->
 <!-- hero area -->
<div class="hero-area hero-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-2 text-center">
                <div class="hero-text">
                    <div class="hero-text-tablecell">
                        <p class="subtitle">CHÀO MỪNG ADMIN</p>
                        <!-- Kiểm tra nếu người dùng đã đăng nhập và hiển thị tên người dùng -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <h1>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                            
                        <?php else: ?>
                            
                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





















	
    
    <div class="container-fluid">
        <div class="row">
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Đóng tất cả các mục khác khi một mục được mở
        const collapses = document.querySelectorAll('.collapse');
        collapses.forEach(collapse => {
            collapse.addEventListener('show.bs.collapse', () => {
                collapses.forEach(otherCollapse => {
                    if (otherCollapse !== collapse) {
                        const bsCollapse = new bootstrap.Collapse(otherCollapse, { toggle: false });
                        bsCollapse.hide();
                    }
                });
            });
        });
    });
</script>
<div class="col-md-3 bg-light p-4">
    <h3 class="text-center">Dashboard</h3>
    <ul class="list-group">
        <!-- Danh sách sản phẩm -->
        <li class="list-group-item">
            <a href="#productMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">Danh sách sản phẩm</a>
            <ul class="collapse list-unstyled" id="productMenu">
                <li><a href="product_list.php" class="d-block ps-3 py-1">Xem sản phẩm</a></li>
                <li><a href="add_product.php" class="d-block ps-3 py-1">Thêm sản phẩm</a></li>
                <li><a href="edit_product.php" class="d-block ps-3 py-1">Sửa sản phẩm</a></li>
            </ul>
        </li>
        
        <!-- Đơn hàng -->
        <li class="list-group-item">
            <a href="#orderMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">Đơn hàng</a>
            <ul class="collapse list-unstyled" id="orderMenu">
                <li><a href="orders.php" class="d-block ps-3 py-1">Xem đơn hàng</a></li>
                <li><a href="order_history.php" class="d-block ps-3 py-1">Lịch sử đơn hàng</a></li>
                <li><a href="order_status.php" class="d-block ps-3 py-1">Trạng thái đơn hàng</a></li>
            </ul>
        </li>

        <!-- Thông tin người dùng -->
        <li class="list-group-item">
            <a href="#userMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">Thông tin người dùng</a>
            <ul class="collapse list-unstyled" id="userMenu">
                <li><a href="user_profile.php" class="d-block ps-3 py-1">Thông tin cá nhân</a></li>
                <li><a href="user_settings.php" class="d-block ps-3 py-1">Cài đặt</a></li>
            </ul>
        </li>

        <!-- Đăng xuất -->
        <li class="list-group-item">
            <a href="logout.php" class="d-block">Đăng xuất</a>
        </li>
    </ul>
</div>



















            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <div class="row">
                    <!-- Card Total Products -->
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-header">
                                <i class="fas fa-box"></i> Tổng Sản Phẩm
                            </div>
                            <div class="card-body text-center">
                                <h3><?php echo $total_products; ?></h3>
                                <p>Đang có tổng cộng các sản phẩm trong kho</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Sales -->
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-header">
                                <i class="fas fa-dollar-sign"></i> Tổng Doanh Thu
                            </div>
                            <div class="card-body text-center">
                                <h3><?php echo number_format($total_sales, 0, ',', '.'); ?> VNĐ</h3>
                                <p>Tổng doanh thu từ tất cả sản phẩm</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Add New Product -->
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-header">
                                <i class="fas fa-plus-circle"></i> Thêm Món Ăn
                            </div>
                            <div class="card-body text-center">
                                <a href="add_product.php" class="btn btn-light btn-lg">Thêm Sản Phẩm</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-clipboard-list"></i> Hoạt Động Mới Nhất
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Đã thêm sản phẩm mới: <strong>Món Gà Rán</strong></li>
                            <li class="list-group-item">Đã cập nhật giá cho món <strong>Pizza Margherita</strong></li>
                            <li class="list-group-item">Đơn hàng mới đã được tạo: <strong>Đơn hàng #1243</strong></li>
                            <li class="list-group-item">Món ăn <strong>Sushi</strong> đã hết hàng.</li>
                        </ul>
                    </div>
                </div>
                  <!-- Recent Activity -->
                  <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-clipboard-list"></i> Hoạt Động Mới Nhất
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Đã thêm sản phẩm mới: <strong>Món Gà Rán</strong></li>
                            <li class="list-group-item">Đã cập nhật giá cho món <strong>Pizza Margherita</strong></li>
                            <li class="list-group-item">Đơn hàng mới đã được tạo: <strong>Đơn hàng #1243</strong></li>
                            <li class="list-group-item">Món ăn <strong>Sushi</strong> đã hết hàng.</li>
                        </ul>
                    </div>
                </div>
                  <!-- Recent Activity -->
                  <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-clipboard-list"></i> Hoạt Động Mới Nhất
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Đã thêm sản phẩm mới: <strong>Món Gà Rán</strong></li>
                            <li class="list-group-item">Đã cập nhật giá cho món <strong>Pizza Margherita</strong></li>
                            <li class="list-group-item">Đơn hàng mới đã được tạo: <strong>Đơn hàng #1243</strong></li>
                            <li class="list-group-item">Món ăn <strong>Sushi</strong> đã hết hàng.</li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
 
    <?php include '../../user_view/component/footer.php'; ?>
    <!-- Bootstrap 4 JS & JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
