<?php
session_start(); // Đảm bảo session được khởi tạo

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "Không tìm thấy người dùng!";
    exit(); // Dừng thực thi nếu người dùng chưa đăng nhập
}

// Lấy id từ session
$user_id = $_SESSION['user_id'];

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Tên đăng nhập CSDL
$password = "";  // Mật khẩu CSDL
$dbname = "food_web";  // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);  // Chèn id vào truy vấn
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng!";
    exit();
}

// Biến để lưu thông báo
$alert_message = "";

// Cập nhật thông tin người dùng khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];

    // Cập nhật thông tin người dùng
    $update_sql = "UPDATE users SET username = ?, email = ?, address = ?, phone = ?, dob = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('sssssi', $username, $email, $address, $phone, $dob, $user_id);

    if ($update_stmt->execute()) {
        $alert_message = "Thông tin đã được cập nhật thành công!";
    } else {
        $alert_message = "Có lỗi xảy ra khi cập nhật thông tin.";
    }

    $update_stmt->close();
}

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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Hiệu ứng hover cho button */
        .button-hover:hover {
            background-color: #007bff;
            transform: scale(1.05);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        /* Hiệu ứng focus cho input */
        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        /* Hiệu ứng mờ dần cho các trường nhập */
        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:hover {
            border-color: #007bff;
            background-color: #f0f9ff;
        }

        /* Hiệu ứng hover cho label */
        .form-label:hover {
            color: #007bff;
            transition: color 0.3s ease;
        }

        /* Hiệu ứng box-shadow khi hover */
        .form-control:focus,
        .form-control:hover {
            box-shadow: 0px 4px 10px rgba(0, 123, 255, 0.4);
        }

        /* Animation khi loading */
        .loading-spinner {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .loading {
            display: block;
        }
    </style>
    

</head>
<body>

    <?php include './component/header_user_home.php'; ?>
    <?php include './component/hero_area_shop.php'; ?>

    <div class="container my-5">
    <h2 class="text-center text-3xl font-semibold text-gray-700 mb-6">CHỈNH SỬA THÔNG TIN NGƯỜI DÙNG</h2>
    
    <form action="edit_profile.php" method="POST" class="space-y-4" onsubmit="showLoading()">
        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label text-lg text-gray-600">Tài Khoản</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label text-lg text-gray-600">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="form-label text-lg text-gray-600">Địa Chỉ</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="form-label text-lg text-gray-600">Số Điện Thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <!-- Date of Birth -->
        <div class="mb-3">
            <label for="dob" class="form-label text-lg text-gray-600">Ngày Sinh</label>
            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn button-hover w-full py-3 text-white font-bold rounded-md">Cập nhật thông tin</button>
    </form>
</div>




<?php include './component/footer.php'; ?>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
