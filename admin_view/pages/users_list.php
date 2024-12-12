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

$sql = "SELECT id, username FROM users";
$result = $conn->query($sql);
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
    <link rel="stylesheet" href="./css/users_list.css">
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
    <h1 class="text-center">Danh Sách Người Dùng</h1>

    <form method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Nhập tên người dùng" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

    <div class="list-group user-list">
        <?php
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $sql = "SELECT * FROM users WHERE username LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = '%' . $search . '%';
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0): 
            while ($row = $result->fetch_assoc()): ?>
                <a href="user_details.php?id=<?= $row['id']; ?>" class="list-group-item">
                    <?= htmlspecialchars($row['username']); ?>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Không có người dùng nào.</p>
        <?php endif; ?>
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
