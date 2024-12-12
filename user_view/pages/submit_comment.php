<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập để bình luận!";
    exit();
}

$message = '';

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

$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$commentText = isset($_POST['comment']) ? $_POST['comment'] : '';
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : ''; 

if (empty($commentText)) {
    echo "Vui lòng nhập bình luận.";
    exit();
}

$query = "INSERT INTO comments (product_id, comment_text, user_name, created_at) 
          VALUES (:product_id, :comment_text, :user_name, NOW())";
$stmt = $pdo->prepare($query);

$stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
$stmt->bindParam(':comment_text', $commentText, PDO::PARAM_STR);
$stmt->bindParam(':user_name', $userName, PDO::PARAM_STR);

$stmt->execute();

header("Location: product_detail.php?id=" . $productId);
exit(); 
?>