<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session
$username = $_SESSION['username'];
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Lấy thông tin người dùng
} else {
    die("Không tìm thấy người dùng.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<!-- title -->
	<title>THỨC ĂN NHÀ MÌNH </title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <!-- CSS and other links -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- Thêm Animate.css vào phần <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</head>
<body>

    <!-- Header and main content -->
    <?php include './component/preloader.php'; ?>
    <?php include './component/header_user_home.php'; ?>


	<div class="profile-hero">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
                        <h1>CHÀO MỪNG BẠN, <?php echo htmlspecialchars($username); ?> </h1>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



<style>
.profile-hero {
    background-image: url('./assets/img/advertise.png'); /* Đường dẫn hình ảnh */
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















    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h3 class="fw-bold">Thông Tin Người Dùng</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="username" class="form-label fs-5">Tài Khoản</label>
                            <input type="text" class="form-control form-control-lg" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fs-5">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fs-5">Địa Chỉ</label>
                            <input type="text" class="form-control form-control-lg" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fs-5">Số Điện Thoại</label>
                            <input type="text" class="form-control form-control-lg" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label fs-5">Ngày Sinh</label>
                            <input type="date" class="form-control form-control-lg" id="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label fs-5">Vai trò</label>
                            <input type="text" class="form-control form-control-lg" id="role" value="<?php echo htmlspecialchars($user['role']); ?>" disabled>
                        </div>

                        <!-- Button to log out -->

                        <div class="text-center mt-4">
    <a href="./edit_profile.php" class="btn btn-danger btn-lg">
        CHỈNH SỬA THÔNG TIN
    </a>
    <a href="./shop_user.php" class="btn btn-danger btn-lg">
        TRANG CHỦ
    </a>
</div>
<style>
    /* Nút mặc định */
    .btn-danger {
        transition: all 0.3s ease; /* Hiệu ứng chuyển đổi mượt mà */
        background-color: #dc3545; /* Màu đỏ mặc định */
        color: white; /* Màu chữ trắng */
        padding: 12px 30px; /* Khoảng cách padding */
        border-radius: 8px; /* Bo tròn các góc */
        border: none; /* Xóa viền */
        font-size: 16px; /* Kích thước font chữ */
    }

    /* Nút khi hover */
    .btn-danger:hover {
        background-color:blueviolet; /* Màu khi hover */
        transform: scale(1.1); /* Tăng kích thước khi hover */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Thêm bóng đổ */
    }
</style>

                     </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include './component/footer.php'; ?>

    <!-- Scripts -->
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>
