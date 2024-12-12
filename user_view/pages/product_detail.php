<?php
session_start();

$message = '';

if (!isset($_SESSION['user_id'])) {
    $message = "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!";
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

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $productId, PDO::PARAM_INT);
$stmt->execute();

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo 'Sản phẩm không tồn tại!';
    exit;
}

$query_comments = "SELECT * FROM comments WHERE product_id = :product_id ORDER BY created_at DESC";
$stmt_comments = $pdo->prepare($query_comments);
$stmt_comments->bindParam(':product_id', $productId, PDO::PARAM_INT);
$stmt_comments->execute();

$comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);
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
	<link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">
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
    <link rel="stylesheet" href="../assets/css/product_detail.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>





<body>

    
    <?php include '../component/header_user_home.php'; ?>
	
	<?php include '../component/hero_area_shop.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4 text-2xl font-bold text-gray-800"><?= htmlspecialchars($product['name']); ?></h2>
    <div class="container my-5">
    <div class="container">
    <div class="row">
        <div class="col product-image-container">
            <img src="<?= $product['image_url']; ?>" class="product-image" alt="Product Image">
        </div>

        <div class="col product-details">
           
            <p class="price"><strong>Giá:</strong> <?= number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
           
            <p class="product-description"><?= nl2br(htmlspecialchars($product['description'])); ?></p>

            <form action="add_to_card.php" method="POST" class="form">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <input type="hidden" name="quantity" value="1">

                <button type="submit" class="btn add-to-cart">Thêm vào giỏ hàng</button>
                <a href="./shop_user.php" class="btn continue-shopping">Tiếp tục mua sắm</a>
            </form>
        </div>
    </div>
</div>
</div>
<div class="mt-5">
    <h3 class="text-2xl font-semibold mb-3">Bình luận</h3>
    <form action="submit_comment.php" method="POST" class="mb-4">
        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
        <div class="form-group">
            <textarea name="comment" class="form-control" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
        </div>
        <button type="submit" class="btn btn-info mt-2">
            <i class="fas fa-paper-plane mr-2"></i> Gửi bình luận
        </button>
    </form>

    <div class="comments-list mt-4">
        <?php if (empty($comments)): ?>
            <p>Hiện tại chưa có bình luận nào.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item bg-light p-4 mb-4 rounded-lg shadow-sm">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-user-circle fa-lg text-primary mr-3"></i>
                        <p class="text-sm font-semibold mb-0"><?= htmlspecialchars($comment['user_name']); ?></p>
                    </div>
                    
                    <p class="text-muted"><?= nl2br(htmlspecialchars($comment['comment_text'])); ?></p>

                    <small class="text-muted">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <?= date("d/m/Y H:i", strtotime($comment['created_at'])); ?>
                    </small>

                    <div class="mt-2">
                        <a href="#" class="text-info">
                            <i class="fas fa-thumbs-up mr-2"></i> Thích
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include '../component/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>