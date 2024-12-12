<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "SELECT o.id, o.total_amount, o.payment_method, o.order_date, u.username
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.status = 'Cancelled'
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Truy vấn thất bại: " . $conn->error);
}
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
    <link rel="stylesheet" href="../../admin_view/pages/css/product_list.css">
    <link rel="stylesheet" href="../../user_view/assets/css/responsive.css">
    <script src="/admin_view/pages/"></script>
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

                    <!-- logo -->
                     <style>
                        .site-logo img {
    width: 100px; 
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}

                     </style>

                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li class="current-list-item"><a href="./index.php">TRANG CHỦ</a></li>
                
                            <?php
                            if (isset($_SESSION['username'])) {
                                $username = $_SESSION['username'];
                                echo '<li class="nav-item">
                                        <a class="nav-link" href="./profile.php">
                                            <i class="bi bi-person-circle"></i> ' . htmlspecialchars($username) . '
                                        </a>
                                      </li>';
                                echo '<li><a href="logout.php">ĐĂNG XUẤT</a></li>';
                            } else {
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
<?php

$session_timeout = 10 * 60;  

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    session_unset(); 
    session_destroy(); 
    header("Location: login.php");  
    exit();
}

$_SESSION['last_activity'] = time();
?>

<div class="hero-area hero-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-2 text-center">
                <div class="hero-text">
                    <div class="hero-text-tablecell">
                        <p class="subtitle">CHÀO MỪNG ADMIN</p>
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
        <h1 class="text-center">Danh Sách Đơn Hàng Bị Hủy</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped table-hover mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên Khách Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Phương Thức Thanh Toán</th>
                        
                        <th>Ngày Đặt Hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result->fetch_assoc()): ?>
                        <tr>
                            <td><i class="fas fa-hashtag text-primary"></i> <?= htmlspecialchars($order['id']); ?></td>
                            <td><i class="fas fa-user text-success"></i> <?= htmlspecialchars($order['username']); ?></td>
                            <td><i class="fas fa-money-bill-wave text-warning"></i> <?= number_format($order['total_amount'], 0, ',', '.'); ?> VND</td>
                            <td><i class="fas fa-credit-card text-info"></i> <?= htmlspecialchars($order['payment_method']); ?></td>
                           
                            <td><i class="fas fa-calendar-alt text-secondary"></i> <?= date("d/m/Y H:i:s", strtotime($order['order_date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-danger">Không có đơn hàng bị hủy.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="orders.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay Lại</a>
        </div>
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
$conn->close();
?>
