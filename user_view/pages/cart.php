<?php
$host = 'localhost';
$db = 'food_web';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($_POST['action'] === 'increase') {
        $quantity++;
    } elseif ($_POST['action'] === 'decrease' && $quantity > 1) {
        $quantity--;
    }

    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $quantity, $user_id, $product_id);
    $stmt->execute();
    header('Location: cart.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    header('Location: cart.php');
    exit();
}

$sql = "SELECT p.id, p.name, p.price, c.quantity, (p.price * c.quantity) AS total_price 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_cart_value = 0;
$cart_items = [];

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_cart_value += $row['total_price'];
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Shop</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
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
    <link rel="stylesheet" href="../assets/css/cart.css">


</head>
<body>
<?php include '../component/header_user_home.php'; ?>
<!-- hero area -->
<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							
							<h1>KIỂM TRA GIỎ HÀNG CỦA BẠN NÀO !   </h1>
                           
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->
    <div class="container mt-5">
    <h2>Giỏ Hàng</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Tổng Tiền</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($cart_items) > 0): ?>
                <?php foreach ($cart_items as $item): ?>
                    <tr class="cart-item">
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <form action="cart.php" method="POST" style="display:inline;" class="cart-form">
                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                
                                <button type="submit" name="action" value="decrease" class="btn btn-warning btn-sm">-</button>
                                
                                <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1" class="form-control d-inline cart-input" style="width: 60px; display:inline-block;" required>
                                
                                <button type="submit" name="action" value="increase" class="btn btn-success btn-sm">+</button>
                            </form>
                        </td>
                        <td><?= number_format($item['total_price'], 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <form action="cart.php" method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                <button type="submit" name="remove_product" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Giỏ hàng của bạn hiện tại trống.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-right">
        <h4>Tổng Tiền: <?= number_format($total_cart_value, 0, ',', '.'); ?> VNĐ</h4>
    </div>

    <div class="text-right mt-4">
        <a href="checkout.php" class="btn btn-success btn-lg">THANH TOÁN</a>
        <a href="shop_user.php" class="btn btn-outline-success btn-lg">TIẾP TỤC MUA HÀNG</a>
    </div>
</div>


    <?php include '../component/footer.php' ?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>