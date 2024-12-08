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
$error_message = ""; // Biến lưu thông báo lỗi

// Cập nhật thông tin người dùng khi form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];

    // Kiểm tra dữ liệu người dùng nhập vào
    if (empty($username)) {
        $error_message = "Tài khoản không được để trống.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email không hợp lệ.";
    } elseif (empty($address)) {
        $error_message = "Địa chỉ không được để trống.";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error_message = "Số điện thoại phải có 10 chữ số.";
    } elseif (empty($dob)) {
        $error_message = "Ngày sinh không được để trống.";
    }

    // Nếu không có lỗi, thực hiện cập nhật thông tin người dùng
    if (empty($error_message)) {
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
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin người dùng</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    
    
    	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">

<!-- CSS and other links -->
<link rel="stylesheet" href="../assets/css/all.min.css">
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/main.css">
<link rel="stylesheet" href="../assets/css/edit_profile.css">
</head>
<body>
<?php include '../component/header_user_home.php'; ?>
<?php include '../component/hero_area.php'; ?>


<div class="form_background">
    <div class="container2 my-5">
        <h2 class="text-center text-3xl font-semibold text-gray-700 mb-6">CHỈNH SỬA THÔNG TIN NGƯỜI DÙNG</h2>
            <!-- Hiển thị thông báo lỗi -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" id="alertMessage">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Hiển thị thông báo thành công -->
    <?php if (!empty($alert_message)): ?>
        <div class="alert alert-success" id="alertMessage">
            <?php echo $alert_message; ?>
        </div>
    <?php endif; ?>
        <form action="edit_profile.php" method="POST" class="space-y-4">
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
            <button type="submit" class="btn btn-primary w-100 py-3 text-white font-bold rounded-md">Cập nhật thông tin</button>
        </form>
    </div>
    </div>

    <script>
        <?php if (!empty($alert_message) || !empty($error_message)): ?>
            // Hiển thị thông báo
            var alertMessage = document.getElementById('alertMessage');
            alertMessage.classList.add('show');  // Thêm lớp show để hiển thị thông báo

            // Ẩn thông báo sau 5 giây
            setTimeout(function() {
                alertMessage.classList.remove('show');  // Loại bỏ lớp show để ẩn thông báo
            }, 5000);
        <?php endif; ?>
    </script>

<?php include '../component/footer.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
