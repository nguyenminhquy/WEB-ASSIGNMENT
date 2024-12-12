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

$alert_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $remain_product = $_POST['remain_product'];
    $image_url = "";

    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $image_url = "../../assets/img/" . basename($_FILES["image_url"]["name"]);
        move_uploaded_file($_FILES["image_url"]["tmp_name"], $image_url);
    }

    if (empty($name) || empty($price) || empty($description) || empty($remain_product)) {
        $alert_message = "Vui lòng điền đầy đủ thông tin.";
    } else {
        $sql = "INSERT INTO products (name, price, description, remain_product, image_url) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error in prepare statement: ' . $conn->error); 
        }

        $stmt->bind_param('sdsss', $name, $price, $description, $remain_product, $image_url);

        if ($stmt->execute()) {
            $alert_message = "Sản phẩm đã được thêm thành công!";
        } else {
            $alert_message = "Có lỗi xảy ra khi thêm sản phẩm.";
        }

        $stmt->close();
    } 
}

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
    <link rel="stylesheet" href="../../admin_view/pages/css/add_product.css">
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
    <style>    
    .site-logo img {
        width: 100px; 
        height: 100px; 
        border-radius: 50%; 
        object-fit: cover; 
    }
    </style>

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
                </div>
            </div>
        </div>
    </div>
</div>
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
                   
                <div class="container2 my-5">
    <h2 class="text-center">THÊM SẢN PHẨM MỚI CHO CỬA HÀNG</h2>

    <?php if (!empty($alert_message)): ?>
        <div class="alert alert-info">
            <?php echo $alert_message; ?>
        </div>
    <?php endif; ?>

    <!-- Form Thêm Sản Phẩm -->
    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Tên Sản Phẩm</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="price">Giá Sản Phẩm</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="available">Tình Trạng (Còn Hàng / Hết Hàng)</label>
            <select class="form-control" id="available" name="available">
                <option value="yes">Còn Hàng</option>
                <option value="no">Hết Hàng</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image_url">Chọn Hình Ảnh</label>
            <input type="file" class="form-control" id="image_url" name="image_url" accept="image/*" required>
        </div>
        <div class="form-group">
    <label for="remain_product">Số Lượng Còn Lại</label>
    <input type="number" class="form-control" id="remain_product" name="remain_product" required>
</div>


        <button type="submit" class="btn btn-primary btn-block">Thêm Sản Phẩm</button>
    </form>
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