<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy giỏ hàng của người dùng
$sql = "SELECT p.name, p.price, c.quantity, (p.price * c.quantity) AS total_price 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Tính tổng tiền giỏ hàng
$total_cart_value = 0;
$cart_items = [];

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_cart_value += $row['total_price'];
}

$stmt->close();
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
    <h2 class="text-center mb-4">Thanh Toán</h2>

    <div class="row">
        <div class="col-md-8">
            <h4>Thông tin giỏ hàng</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Số Lượng</th>
                        <th>Tổng Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']); ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                            <td><?= $item['quantity']; ?></td>
                            <td><?= number_format($item['total_price'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h5>Tổng Tiền Giỏ Hàng: <?= number_format($total_cart_value, 0, ',', '.'); ?> VNĐ</h5>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="col-md-4">
            <h4>Chọn Phương Thức Thanh Toán</h4>
            <form action="process_payment.php" method="POST">
                <div class="form-group">
                    <label for="payment_method">Phương thức thanh toán:</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="cash">Thanh toán tiền mặt khi nhận hàng</option>
                        <option value="credit_card">Thẻ tín dụng (Visa, MasterCard)</option>
                        <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                    </select>
                </div>

                <input type="hidden" name="total_amount" value="<?= $total_cart_value; ?>">

                <button type="submit" class="btn btn-success mt-3">Xác Nhận Thanh Toán</button>
            </form>
        </div>










		
    </div>
</div>

<?php include './component/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
