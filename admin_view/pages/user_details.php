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

$user_id = intval($_GET['id']);
$sql_user = "SELECT * FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

$sql_orders = "SELECT id, total_amount, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$order_result = $stmt_orders->get_result();

$sql_cart = "SELECT p.name, c.quantity, (p.price * c.quantity) AS total_price 
             FROM cart c 
             JOIN products p ON c.product_id = p.id 
             WHERE c.user_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$cart_result = $stmt_cart->get_result();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
    <link rel="stylesheet" href="./css/users_list.css">
    <script src="/admin_view/pages/"></script>
    <link rel="stylesheet" href="./css/user_details.css">
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
    <h1 class="text-center">Thông Tin Người Dùng</h1>

    <?php if ($user): ?>
        <div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title">
            <i class="fas fa-user-circle me-2"></i> 
            <?= htmlspecialchars($user['username']); ?>
        </h3>
        <p>
            <i class="fas fa-envelope me-2"></i> 
            <strong>Email:</strong> <?= htmlspecialchars($user['email']); ?>
        </p>
        <p>
            <i class="fas fa-calendar-alt me-2"></i> 
            <strong>Ngày Tạo:</strong> <?= date("d/m/Y", strtotime($user['created_at'])); ?>
        </p>
    </div>
</div>


        <h2 class="mt-4">Lịch Sử Mua Hàng</h2>
        <?php if ($order_result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tổng Tiền</th>
                        <th>Ngày Đặt Hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $order_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id']); ?></td>
                            <td><?= number_format($order['total_amount'], 0, ',', '.'); ?> VND</td>
                            <td><?= date("d/m/Y", strtotime($order['order_date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có lịch sử mua hàng.</p>
        <?php endif; ?>

        <h2 class="mt-4">Giỏ Hàng Hiện Tại</h2>
        <?php if ($cart_result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Thành Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cart_item = $cart_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($cart_item['name']); ?></td>
                            <td><?= htmlspecialchars($cart_item['quantity']); ?></td>
                            <td><?= number_format($cart_item['total_price'], 0, ',', '.'); ?> VND</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Giỏ hàng trống.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Người dùng không tồn tại.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="users_list.php" class="btn btn-secondary">Quay Lại</a>
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