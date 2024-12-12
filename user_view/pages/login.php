<?php
session_start(); 
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "food_web"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE username = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user);  
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        
        if (password_verify($pass, $user_data['password'])) {
           
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['role'] = $user_data['role'];
            
            session_regenerate_id(true);
            
            if ($_SESSION['role'] == 'admin') {
                header("Location: ../../admin_view/pages/index.php");  
                exit();
            } else {
                header("Location: ./shop_user.php");  
                exit();
            }
        } else {
            $error_message = "Mật khẩu không đúng! - VUI LÒNG NHẬP LẠI MẬT KHẨU ";
        }
    } else {
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
    background-image: url('../assets/img/sunga.jpg'); 
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat; 
    background-attachment: fixed; 
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white; 
}

.hero-text h1 {
    font-size: 3rem;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); 
    margin: 0; 
    padding: 0; 
}
.hero-text-tablecell {
    display: inline-block;
    vertical-align: middle;
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem;
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

                    <div class="my-4 text-center">
                        <p>Hoặc đăng nhập bằng</p>
                        <div class="d-flex justify-content-center">
                            <a href="google_login.php" class="btn btn-outline-danger btn-lg mx-2 w-50">
                                <i class="fab fa-google"></i> Google
                            </a>
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