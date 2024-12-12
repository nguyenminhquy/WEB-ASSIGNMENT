<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if (empty($comment)) {
    echo 'Bình luận không được để trống!';
    exit();
}

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

$username = $_SESSION['username'];

$query = "INSERT INTO comments (product_id, username, comment, created_at) 
          VALUES (:product_id, :username, :comment, NOW())";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->execute();

header("Location: ./product_detail.php?id=" . $product_id);
exit();
?>
