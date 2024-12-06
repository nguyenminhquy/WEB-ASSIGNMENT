<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập để bình luận!";
    exit();
}

$message = ''; // Biến chứa thông báo

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

// Lấy dữ liệu từ form
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$commentText = isset($_POST['comment']) ? $_POST['comment'] : '';
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // Lấy tên người dùng từ session

// Kiểm tra xem người dùng đã nhập bình luận hay chưa
if (empty($commentText)) {
    echo "Vui lòng nhập bình luận.";
    exit();
}

// Thêm bình luận vào cơ sở dữ liệu
$query = "INSERT INTO comments (product_id, comment_text, user_name, created_at) 
          VALUES (:product_id, :comment_text, :user_name, NOW())";
$stmt = $pdo->prepare($query);

// Gắn giá trị vào các tham số trong câu lệnh SQL
$stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
$stmt->bindParam(':comment_text', $commentText, PDO::PARAM_STR);
$stmt->bindParam(':user_name', $userName, PDO::PARAM_STR);

// Thực thi câu lệnh SQL
$stmt->execute();

// Sau khi thêm bình luận thành công, chuyển hướng về trang product_detail.php
header("Location: product_detail.php?id=" . $productId);
exit(); // Đảm bảo rằng không có mã nào được thực thi sau khi chuyển hướng
?>
