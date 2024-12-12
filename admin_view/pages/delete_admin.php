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

$records_per_page = 5;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

$offset = ($current_page - 1) * $records_per_page;

$sql = "SELECT id, username, email, address, phone, dob, created_at FROM users WHERE role = 'admin' ORDER BY created_at DESC LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

$sql_total = "SELECT COUNT(*) AS total FROM users WHERE role = 'admin'";
$result_total = $conn->query($sql_total);
$row = $result_total->fetch_assoc();
$total_records = $row['total'];

$total_pages = ceil($total_records / $records_per_page);

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_list.php");
    exit();
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
    <h1 class="text-center mb-4">Danh Sách Admin</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Người Dùng</th>
                        <th>Email</th>
                        <th>Địa Chỉ</th>
                        <th>Số Điện Thoại</th>
                        <th>Ngày Sinh</th>
                        <th>Ngày Tham Gia</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['address']); ?></td>
                            <td><?= htmlspecialchars($user['phone']); ?></td>
                            <td><?= htmlspecialchars($user['dob']); ?></td>
                            <td><?= htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $user['id']; ?>">Xóa</button>
                                <div class="modal fade" id="deleteModal<?= $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= $user['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?= $user['id']; ?>">Xác Nhận Xóa</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa nhân viên này không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                <a href="?delete_id=<?= $user['id']; ?>" class="btn btn-danger">Xóa</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">Không có admin nào trong hệ thống.</p>
    <?php endif; ?>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item <?= $current_page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=1">Đầu</a>
            </li>
            <li class="page-item <?= $current_page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $current_page - 1; ?>">Trước</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $current_page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $current_page + 1; ?>">Tiếp</a>
            </li>
            <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= $total_pages; ?>">Cuối</a>
            </li>
        </ul>
    </nav>
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
