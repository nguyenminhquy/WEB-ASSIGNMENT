<?php
include "../config/connect_db.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">
	<title>THỨC ĂN NHÀ MÌNH </title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="../../assets/img/logo.jpg">
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
    <?php
    include_once"../includes/header.php"
    ?>


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
            <div class="col-md-2 bg-light p-4">
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
                    <!--  -->
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
            <div class="container col-md-9 my-5">
                <div class="justify-content-between align-items-center mb-4">
                    <h1>Danh sách sản phẩm</h1>
                    <button id="create-new" onclick="window.location.href='add_product.php'" class="btn btn-success">Thêm sản phẩm mới</button>
                </div>
                <table border="1" cellpadding='6' cellspacing='0' table table-striped table-hover table-bordered align-middle>
                    <thead class="bg-dark text-white text-center">
                        <tr id="title-table">
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='text-center'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . number_format($row['price'], 0, ',', '.') . " VNĐ</td>";
                                echo "<td><img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' width='150' height='150'></td>";
                                echo "<td>";
                                echo "<button id='delete' onclick=\"window.location.href='delete.php?product_id=" . $row['id'] . "'\">Xóa</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted';>Không có sản phẩm nào.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
