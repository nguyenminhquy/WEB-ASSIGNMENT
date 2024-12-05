<!-- header -->
<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- logo -->
                    <div class="site-logo">
                        <a href="index.html">
                            <img src="assets/img/logo.jpg" alt="">
                        </a>
                    </div>
                    <!-- logo -->

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
                                echo '<li><a href="../register.php">ĐĂNG KÍ</a></li>';
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
