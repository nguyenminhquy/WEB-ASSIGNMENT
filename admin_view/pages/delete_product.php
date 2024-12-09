<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xóa sản phẩm nếu người dùng nhấn nút xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $product_id = intval($_POST['delete_product_id']);
    $sql_delete = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        $message = "Sản phẩm đã được xóa thành công!";
    } else {
        $message = "Xóa sản phẩm thất bại. Vui lòng thử lại.";
    }
    $stmt->close();
}

// Truy vấn tất cả sản phẩm
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$items_per_page = 3;

// Xác định trang hiện tại (nếu không có thì mặc định là 1)
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Không cho phép giá trị nhỏ hơn 1

// Tính OFFSET
$offset = ($current_page - 1) * $items_per_page;

// Lấy tổng số sản phẩm
$sql_count = "SELECT COUNT(*) AS total FROM products";
$result_count = $conn->query($sql_count);
$total_items = $result_count->fetch_assoc()['total'];

// Tính tổng số trang
$total_pages = ceil($total_items / $items_per_page);

// Lấy danh sách sản phẩm cho trang hiện tại
$sql_products = "SELECT * FROM products LIMIT $items_per_page OFFSET $offset";
$result_pagination = $conn->query($sql_products);
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
    <link rel="stylesheet" href="../../admin_view/pages/css/delete_product.css">
    <link rel="stylesheet" href="../../user_view/assets/css/responsive.css">
    <script src="../pages/js/delete_product.js"></script>
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
<?php include './sidebar.php'; ?>
</div>



    

            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <div class="row">
                                








                <div class="container mt-5">
    <h1 class="text-center">Danh Sách Sản Phẩm</h1>
    
    <!-- Hiển thị thông báo -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="product-list">
    <div class="row">
        <?php if ($result_pagination->num_rows > 0): ?>
            <?php while ($product = $result_pagination->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="product-card">
                        <img class="product-image" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="product-info">
                            <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p>Giá: <?php echo number_format($product['price'], 2); ?> VND</p>
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Không có sản phẩm nào để hiển thị.</p>
        <?php endif; ?>
    </div>
</div>

<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <?php if ($current_page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>">← Trang trước</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">← Trang trước</span>
            </li>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Trang sau →</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Trang sau →</span>
            </li>
        <?php endif; ?>
    </ul>
</nav>

</div>
</div>
</div>

<?php include '../../user_view/component/footer.php'; ?>
<!-- Bootstrap 4 JS & JQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
