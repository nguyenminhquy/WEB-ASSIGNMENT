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
    $role = $_POST['role']; // Role có thể là 'customer' hoặc 'admin'

    // Kiểm tra xem username đã tồn tại chưa
    $sql_check = "SELECT * FROM users WHERE username = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param('s', $user);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error_message = "Tài khoản đã tồn tại!";
        } else {
            
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Lưu thông tin người dùng vào cơ sở dữ liệu
            $sql_insert = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            if ($stmt_insert = $conn->prepare($sql_insert)) {
                $stmt_insert->bind_param('sss', $user, $hashed_password, $role);
                
                if ($stmt_insert->execute()) {
                    // Đăng ký thành công, chuyển hướng đến trang đăng nhập
                    header("Location: login.php");
                    exit();
                } else {
                    $error_message = "Lỗi khi đăng ký tài khoản!";
                }
                $stmt_insert->close();
            } else {
                $error_message = "Lỗi khi chuẩn bị câu lệnh SQL để chèn dữ liệu!";
            }
        }

        $stmt_check->close();
    } else {
        $error_message = "Lỗi khi chuẩn bị câu lệnh SQL kiểm tra tên đăng nhập!";
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
	<title>THỨC ĂN NHÀ MÌNH  </title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="../assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="../assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="../assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="../assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="../assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="../assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="../assets/css/responsive.css">

</head>
<body>
	

     <?php include '../component/preloader.php'; ?>
     <?php include '../component/header.php'; ?>
	<!-- hero area -->
<div class="hero-area hero-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-2 text-center">
                <div class="hero-text">
                    <div class="hero-text-tablecell">
                       
                        <h1>ĐĂNG KÍ THÀNH VIÊN ĐỂ HƯỞNG NHIỀU ƯU ĐÃI</h1>
                        <p class="subtitle">Ăn ngon quá xá không lo về giá !</p>
                       
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg border-0">
                <div class="card-header bg-blue-600 text-white text-center py-4">
                    <h3>Đăng Ký Tài Khoản</h3>
                </div>
                <div class="card-body p-5">
                    <!-- Form đăng ký -->
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tài Khoản</label>
                            <input type="text" class="form-control" id="username" name="username" required placeholder="Nhập tên tài khoản">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật Khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Nhập mật khẩu">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa Chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" required placeholder="Nhập địa chỉ của bạn">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" required placeholder="Nhập số điện thoại">
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Ngày Sinh</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Vai trò</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="customer">Khách Hàng</option>
                                <option value="admin">Quản Trị</option>
                            </select>
                        </div>

                        <?php
                        if (isset($error_message)) {
                            echo "<div class='alert alert-danger mt-3'>$error_message</div>";
                        }
                        ?>
                        
                        <button type="submit" class="btn btn-primary w-full py-3 mt-4 transition-all duration-300 hover:bg-blue-700">Đăng Ký</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-sm">Đã có tài khoản? <a href="login.php" class="text-blue-600 hover:text-blue-800">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast thông báo -->
<?php if (isset($error_message)): ?>
    <div class="toast align-items-center text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body">
                <?php echo $error_message; ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>



	
	
	<?php include '../component/footer.php'; ?>

	
	
	
	
	<!-- jquery -->
	<script src="../assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="vassets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="../assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="../assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="../assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="../assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="../assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="../assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="../assets/js/main.js"></script>

</body>
</html>