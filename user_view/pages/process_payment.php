<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment_method'] ?? '';  
$total_amount = 0;

if (empty($payment_method)) {
    $_SESSION['error'] = "Vui lòng chọn phương thức thanh toán!";
    header("Location: checkout.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_cart_total = "SELECT SUM(p.price * c.quantity) AS total 
                   FROM cart c 
                   JOIN products p ON c.product_id = p.id 
                   WHERE c.user_id = ?";
$stmt_cart_total = $conn->prepare($sql_cart_total);
$stmt_cart_total->bind_param('i', $user_id);
$stmt_cart_total->execute();
$result_cart_total = $stmt_cart_total->get_result();

if ($row = $result_cart_total->fetch_assoc()) {
    $total_amount = $row['total'];
}

$stmt_cart_total->close();

if ($total_amount == 0) {
    $_SESSION['error'] = "Giỏ hàng của bạn không có sản phẩm.";
    header("Location: checkout.php");
    exit();
}

$sql_insert_order = "INSERT INTO orders (user_id, total_amount, payment_method, order_date) 
                     VALUES (?, ?, ?, NOW())";
$stmt_insert_order = $conn->prepare($sql_insert_order);
$stmt_insert_order->bind_param('iis', $user_id, $total_amount, $payment_method);
$stmt_insert_order->execute();

$order_id = $stmt_insert_order->insert_id;

$sql_cart_items = "SELECT product_id, quantity FROM cart WHERE user_id = ?";
$stmt_cart_items = $conn->prepare($sql_cart_items);
$stmt_cart_items->bind_param('i', $user_id);
$stmt_cart_items->execute();
$result_cart_items = $stmt_cart_items->get_result();

while ($row = $result_cart_items->fetch_assoc()) {
    $sql_insert_item = "INSERT INTO order_items (order_id, product_id, quantity) 
                        VALUES (?, ?, ?)";
    $stmt_insert_item = $conn->prepare($sql_insert_item);
    $stmt_insert_item->bind_param('iii', $order_id, $row['product_id'], $row['quantity']);
    $stmt_insert_item->execute();
}

$stmt_insert_item->close();

$sql_delete_cart = "DELETE FROM cart WHERE user_id = ?";
$stmt_delete_cart = $conn->prepare($sql_delete_cart);
$stmt_delete_cart->bind_param('i', $user_id);
$stmt_delete_cart->execute();

$stmt_delete_cart->close();

$conn->close();

$_SESSION['success'] = "Thanh toán thành công! Đơn hàng của bạn đã được xử lý.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>SHOPPING WEB </title>

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

</head>
<body>
<?php include '../component/header_user_home.php'; ?>
<div class="hero-area hero-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-2 text-center">
                <div class="hero-text">
                    <div class="hero-text-tablecell">
                        <h1>CHÀO TẠM BIỆT, HẸN GẶP LẠI!</h1>
                        <p class="subtitle">Cảm ơn bạn đã mua sắm cùng chúng tôi 💖😊</p>
                        <div class="icons">
                            <span class="icon"><i class="fas fa-heart"></i></span>
                            <span class="icon"><i class="fas fa-thumbs-up"></i></span>
                            <span class="icon"><i class="fas fa-smile"></i></span>
                            <span class="icon"><i class="fas fa-handshake"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success transition-all duration-300 ease-in-out transform hover:scale-105" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger transition-all duration-300 ease-in-out transform hover:scale-105" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="text-center mt-5">
        <p class="text-lg text-gray-700">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn sẽ được xử lý trong thời gian sớm nhất.</p>
        
        <div class="mt-4 space-x-4">
            <a href="./order_history.php" class="btn btn-primary px-6 py-3 bg-blue-500 text-white rounded-full transition-colors hover:bg-blue-600 focus:outline-none">
                <i class="fas fa-history mr-2"></i> Xem lịch sử đơn hàng
            </a>
            <a href="./shop_user.php" class="btn btn-secondary px-6 py-3 bg-gray-600 text-white rounded-full transition-colors hover:bg-gray-700 focus:outline-none">
                <i class="fas fa-home mr-2"></i> Quay lại trang chủ
            </a>
        </div>
    </div>
</div>


<?php include '../component/footer.php'; ?>

</body>
</html>
