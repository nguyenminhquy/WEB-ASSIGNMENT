<?php
session_start();

$message = ''; // Biến chứa thông báo

if (!isset($_SESSION['user_id'])) {
    $message = "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!";
    exit();
}

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $message = "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error;
    exit();
}

$sql_check = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param('ii', $user_id, $product_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $sql_update = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('iii', $quantity, $user_id, $product_id);
    $stmt_update->execute();
    $message = "Sản phẩm đã được thêm vào giỏ hàng!";
    $stmt_update->close();
} else {
    $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('iii', $user_id, $product_id, $quantity);
    $stmt_insert->execute();
    $message = "Sản phẩm đã được thêm vào giỏ hàng!";
    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPPING WEB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container my-5">
        <?php if ($message): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <!-- Bạn có thể chuyển hướng người dùng sau vài giây -->
        <a href="shop_user.php" class="btn btn-primary">TIẾP TỤC MUA HÀNG </a>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

