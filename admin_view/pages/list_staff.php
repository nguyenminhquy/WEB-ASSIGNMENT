<?php
// list_staff.php

// Gọi model để lấy dữ liệu nhân viên
require_once '../models/staff.php';
$staff = get_all_staff();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - Bootstrap 5 Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                 

                   <div class="navbar-nav w-100">
                    
                    <div class="nav-item dropdown">
                        
                        <div class="dropdown-menu bg-transparent border-0">
                           <a href="danhsachsanpham.php" class="dropdown-item">DANH SÁCH SẢN PHẨM </a>
                           <a href="themsanpham.php" class="dropdown-item">THÊM SẢN PHẨM MỚI  </a>
                           <a href="xoasanpham.php" class="dropdown-item">XÓA SẢN PHẨM </a>
                           <a href="chinhsanpham.php" class="dropdown-item">CHỈNH SỬA SẢN PHẨM  </a>
                        </div>
                    </div>

                   
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
 
   


            <!-- Blank Start -->
                      
           

            <div class="container my-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">DANH SÁCH NHÂN VIÊN </h2>
        <a href="dashboard.php" class="btn btn-success">QUAY LẠI</a>
    </div>
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>ID</th>
                    <th>Tên Nhân Viên</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Chức Vụ</th>
                    <th>Tên Đăng Nhập</th>
                    <th>Mật Khẩu</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($staff)): ?>
                    <?php foreach ($staff as $member): ?>
                        <tr>
                            <td class="text-center"><?php echo htmlspecialchars($member['staff_id']); ?></td>
                            <td><?php echo htmlspecialchars($member['name']); ?></td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($member['phone']); ?></td>
                            <td><?php echo htmlspecialchars($member['position']); ?></td>
                            <td><?php echo htmlspecialchars($member['username']); ?></td>
                            <td><?php echo htmlspecialchars($member['password']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Không có nhân viên nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>













            <!-- Blank End -->


        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
