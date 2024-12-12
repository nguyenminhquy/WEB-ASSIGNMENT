<?php
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

$query = "SELECT * FROM products";
$stmt = $pdo->query($query);

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
<style>
.product-lists {
    display: flex;
    flex-wrap: wrap;
    gap: 30px; 
}


.single-product-item {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    box-sizing: border-box;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}


.product-image {
    position: relative;
    width: 100%;
    height: 200px; 
    overflow: hidden;
}

.product-image img {
    object-fit: cover; 
    width: 100%;
    height: 100%;
}

.single-product-item h3 {
    font-size: 18px;
    margin: 10px 0;
    height: 50px; 
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.product-price {
    font-size: 16px;
    font-weight: bold;
    margin: 10px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 40px; 
}

.cart-btn {
    text-align: center;
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    margin-top: auto;
    transition: background-color 0.3s;
}

.cart-btn:hover {
    background-color: #0056b3;
}

.col-lg-4, .col-md-6 {
    display: flex;
    justify-content: center;
    align-items: stretch;
    flex: 1 1 30%; 
    max-width: 33%;
}

@media (max-width: 992px) {
    .col-lg-4 {
        flex: 1 1 45%;
        max-width: 45%; 
    }
}

@media (max-width: 768px) {
    .col-md-6 {
        flex: 1 1 100%;
        max-width: 100%; 
    }
}


</style>
        <div class="row product-lists">
    <?php foreach ($products as $product): ?>
        <?php 
        $categoryClass = strtolower($product['category'] ?? ''); 
        ?>
        <div class="col-lg-4 col-md-6 text-center <?= $categoryClass; ?>">
            <div class="single-product-item">
                <div class="product-image">
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