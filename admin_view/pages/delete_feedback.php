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

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])) {
    $comment_id = intval($_POST['comment_id']);
    $sql_delete = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $comment_id);

    if ($stmt->execute()) {
        $message = "Bình luận đã được xóa thành công!";
    } else {
        $message = "Xóa bình luận thất bại. Vui lòng thử lại.";
    }
    $stmt->close();
}
$sql = "SELECT c.id, c.comment_text, c.created_at, c.user_name, p.name AS product_name
        FROM comments c
        JOIN products p ON c.product_id = p.id
        ORDER BY c.created_at DESC";
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
      <h1 class="text-center mb-4">Danh Sách Bình Luận</h1>
        <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên Người Dùng</th>
                    <th>Sản Phẩm</th>
                    <th>Bình Luận</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['user_name']); ?></td>
                        <td><?= htmlspecialchars($row['product_name']); ?></td>
                        <td><?= htmlspecialchars($row['comment_text']); ?></td>
                        <td><?= date("d/m/Y H:i:s", strtotime($row['created_at'])); ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="comment_id" value="<?= $row['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Không có bình luận nào.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="./index.php" class="btn btn-primary">Quay Lại Dashboard</a>
    </div>
</div>

<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= htmlspecialchars($message); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($message)): ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        messageModal.show();
    });
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
