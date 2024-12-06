<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    exit();
}

// Lấy dữ liệu từ form
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

// Kiểm tra dữ liệu hợp lệ
if (empty($comment)) {
    echo 'Bình luận không được để trống!';
    exit();
}

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$db = 'food_web';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Kết nối thất bại: ' . $e->getMessage();
    exit;
}

// Lấy tên người dùng từ session
$username = $_SESSION['username'];

// Thêm bình luận vào cơ sở dữ liệu
$query = "INSERT INTO comments (product_id, username, comment, created_at) 
          VALUES (:product_id, :username, :comment, NOW())";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->execute();

// Sau khi thêm thành công, chuyển hướng lại trang chi tiết sản phẩm
header("Location: ./product_detail.php?id=" . $product_id);
exit();
?>
