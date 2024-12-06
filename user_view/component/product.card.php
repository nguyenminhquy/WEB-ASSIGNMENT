<?php
// Kết nối cơ sở dữ liệu (đảm bảo bạn đã kết nối đúng)
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

// Truy vấn dữ liệu từ bảng sản phẩm
$query = "SELECT * FROM products";
$stmt = $pdo->query($query);

// Lấy tất cả các sản phẩm từ cơ sở dữ liệu
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-filters">
                    <ul>
                        <li class="active" data-filter="*">Tất cả</li>
                       
                    </ul>
                </div>
            </div>
        </div>

        <div class="row product-lists">
    <?php foreach ($products as $product): ?>
        <!-- Xác định lớp phân loại nếu có -->
        <?php 
        $categoryClass = strtolower($product['category'] ?? ''); // Thêm phân loại sản phẩm nếu có
        ?>
        <div class="col-lg-4 col-md-6 text-center <?= $categoryClass; ?>">
            <div class="single-product-item">
                <div class="product-image">
                    <!-- Hình ảnh sản phẩm -->
                    <a href="product_detail.php?id=<?= $product['id']; ?>">
                        <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    </a>
                </div>
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <p class="product-price"><span>Giá</span> <?= number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                <a href="product_detail.php?id=<?= $product['id']; ?>" class="cart-btn"> Xem chi tiết</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="pagination-wrap">
                    <ul>
                        <li><a href="#">Trước</a></li>
                        <li><a href="#">1</a></li>
                        <li><a class="active" href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">Tiếp</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end products -->


   
</body>
