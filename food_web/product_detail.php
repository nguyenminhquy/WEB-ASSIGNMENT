<?php



session_start();

$message = ''; // Biến chứa thông báo

if (!isset($_SESSION['user_id'])) {
    $message = "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!";
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

// Lấy id sản phẩm từ URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Truy vấn chi tiết sản phẩm
$query = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $productId, PDO::PARAM_INT);
$stmt->execute();

// Lấy dữ liệu sản phẩm
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo 'Sản phẩm không tồn tại!';
    exit;
}
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
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">

</head>





<body>

    
    <?php include './component/header_user_home.php'; ?>
	<?php include './search_area.php'; ?>
	<?php include './component/hero_area_shop.php'; ?>








    <div class="container my-5">
    <h2 class="text-center mb-4 text-2xl font-bold"><?= htmlspecialchars($product['name']); ?></h2>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 product-image-container mb-4 mb-md-0">
            <img src="<?= $product['image_url']; ?>" class="img-fluid rounded-lg shadow-lg" alt="Product Image">
        </div>

        <!-- Product Details -->
        <div class="col-md-6 product-details">
            <p class="text-lg text-gray-700"><strong>Giá:</strong> <?= number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
            <p class="text-lg text-gray-700"><strong>Mô tả:</strong></p>
            <p class="text-gray-600"><?= nl2br(htmlspecialchars($product['description'])); ?></p>

            <!-- Thêm vào giỏ hàng -->
            <form action="add_to_card.php" method="POST" class="mt-4">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <input type="hidden" name="quantity" value="1"> <!-- Giả sử số lượng mặc định là 1 -->
                <button type="submit" class="btn btn-primary btn-lg w-full mb-2">Thêm vào giỏ hàng</button>
                <a href="./user_home.php" class="btn btn-success btn-lg w-full">Tiếp tục mua sắm</a>
            </form>
        </div>
    </div>

    <!-- Phần bình luận -->
    <div class="mt-5">
        <h3 class="text-2xl font-semibold mb-3">Bình luận</h3>
        <form action="submit_comment.php" method="POST" class="mb-4">
            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
            <div class="form-group">
                <textarea name="comment" class="form-control" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
            </div>
            <button type="submit" class="btn btn-info mt-2">Gửi bình luận</button>
        </form>

        <!-- Hiển thị các bình luận -->
        <div class="comments-list">
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item bg-gray-100 p-4 mb-4 rounded-lg shadow-sm">
                    <p class="text-sm font-semibold"><?= htmlspecialchars($comment['username']); ?></p>
                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    <small class="text-gray-500"><?= date("d/m/Y H:i", strtotime($comment['created_at'])); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

    <?php include './component/footer.php'; ?>

    </div>
   

    <!-- Bootstrap 5 JS & Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
