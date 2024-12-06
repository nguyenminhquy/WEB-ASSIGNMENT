<?php
session_start();  // Bắt đầu phiên làm việc

// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Tên đăng nhập CSDL
$password = "";  // Mật khẩu CSDL
$dbname = "food_web";  // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu người dùng đã gửi dữ liệu qua POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
    $sql = "SELECT * FROM users WHERE username = ?"; // Truy vấn người dùng theo username
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user);  // Chèn username vào truy vấn
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin người dùng
        $user_data = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu có khớp không (so với mật khẩu đã mã hóa trong CSDL)
        if (password_verify($pass, $user_data['password'])) {
           
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['role'] = $user_data['role'];
            
            // Tạo một session mới để bảo mật hơn
            session_regenerate_id(true);
            
            // Kiểm tra vai trò của người dùng
            if ($_SESSION['role'] == 'admin') {
                // Nếu là admin, chuyển hướng đến trang quản trị
                header("Location: ../../admin_view/pages/index.php");  
                exit();
            } else {
                // Nếu là customer, chuyển hướng đến trang khách hàng
                header("Location: ./shop_user.php");  
                exit();
            }
        } else {
            // Mật khẩu sai
            $error_message = "Mật khẩu không đúng! - VUI LÒNG NHẬP LẠI MẬT KHẨU ";
        }
    } else {
        // Tài khoản không tồn tại
        $error_message = "Tài khoản không tồn tại!";
    }

    $stmt->close();
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
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
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

</head>
<body>
	

     <?php include '../component/header.php'; ?>
	<?php include '../component/header_login.php'; ?>


<div class="login-hero">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							
							<h1>HÃY ĐĂNG NHẬP ĐỄ BẮT ĐẦU MUA SẮM NHA !</h1>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



<style>
.login-hero {
    background-image: url('../assets/img/sunga.jpg'); /* Đường dẫn hình ảnh */
    background-size: cover; /* Đảm bảo ảnh bao phủ toàn bộ phần tử */
    background-position: center center; /* Căn chỉnh ảnh ở giữa */
    background-repeat: no-repeat; /* Ngăn chặn việc lặp lại ảnh */
    background-attachment: fixed; /* Làm cho hình nền cố định khi cuộn trang */
    height: 100vh; /* Chiếm toàn bộ chiều cao màn hình */
    display: flex;
    justify-content: center;
    align-items: center;
    color: white; /* Màu chữ trắng để dễ đọc trên nền tối */
}

.hero-text h1 {
    font-size: 3rem; /* Tùy chỉnh kích thước chữ */
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Đổ bóng chữ để rõ ràng hơn */
    margin: 0; /* Loại bỏ margin mặc định */
    padding: 0; /* Loại bỏ padding mặc định */
}

.hero-text-tablecell {
    display: inline-block;
    vertical-align: middle; /* Giữ cho phần tử căn giữa theo chiều dọc */
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem; /* Giảm kích thước chữ trên màn hình nhỏ */
    }
}

</style>
	

    <div class="container-fluid px-0 my-5">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h3 class="fw-bold">Đăng Nhập</h3>
                </div>
                <div class="card-body p-5">
                    <!-- Form đăng nhập -->
                    <form action="login.php" method="POST">
                        <div class="mb-4">
                            <label for="username" class="form-label fs-5">Tài Khoản</label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fs-5">Mật Khẩu</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                        </div>
                        <?php
                        if (isset($error_message)) {
                            echo "<div class='alert alert-danger'>$error_message</div>";
                        }
                        ?>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Đăng Nhập</button>
                    </form>

                    <!-- Tùy chọn đăng nhập qua Google và Facebook -->
                    <div class="my-4 text-center">
                        <p>Hoặc đăng nhập bằng</p>
                        <div class="d-flex justify-content-center">
                            <!-- Đăng nhập qua Google -->
                            <a href="google_login.php" class="btn btn-outline-danger btn-lg mx-2 w-50">
                                <i class="fab fa-google"></i> Google
                            </a>
                            <!-- Đăng nhập qua Facebook -->
                            <a href="facebook_login.php" class="btn btn-outline-primary btn-lg mx-2 w-50">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="fs-6">Chưa có tài khoản? <a href="register.php" class="text-decoration-none text-primary fw-bold">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





	<?php include '../component/footer.php'; ?>

	
	
	
	
	<!-- jquery -->
	<script src="../../user_view/assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="../../user_view/assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="../../user_view/assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="../../user_view/assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="../../user_view/assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="../../user_view/assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="../../user_view/assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="../../user_view/assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="../../user_view/assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="../../user_view/assets/js/main.js"></script>

</body>
</html>