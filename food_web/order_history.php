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

// Tìm kiếm đơn hàng theo ID đơn hàng hoặc phương thức thanh toán
$search_query = "";
if (isset($_GET['search_order_id']) && !empty($_GET['search_order_id'])) {
    $search_query = "AND o.id = " . $_GET['search_order_id'];
}
if (isset($_GET['search_payment_method']) && !empty($_GET['search_payment_method'])) {
    $search_query .= " AND o.payment_method LIKE '%" . $_GET['search_payment_method'] . "%'";
}

// Lấy lịch sử đơn hàng của người dùng
$sql_orders = "SELECT o.id, o.total_amount, o.payment_method, o.order_date 
               FROM orders o 
               WHERE o.user_id = ? $search_query
               ORDER BY o.order_date DESC";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param('i', $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
<?php include './component/header_user_home.php'; ?>

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
    <h2 class="text-2xl font-semibold mb-4">Lịch sử đơn hàng của bạn</h2>

 

    <!-- Hiển thị danh sách đơn hàng -->
    <?php
    if ($result_orders->num_rows > 0) {
        while ($order = $result_orders->fetch_assoc()) {
            // Hiển thị thông tin đơn hàng
            echo "<div class='card mb-4 shadow-lg rounded'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title text-xl font-bold'>Đơn hàng #" . $order['id'] . "</h5>";
            echo "<p><strong>Tổng tiền:</strong> " . number_format($order['total_amount'], 0, ',', '.') . " VND</p>";
            echo "<p><strong>Phương thức thanh toán:</strong> " . $order['payment_method'] . "</p>";
            echo "<p><strong>Ngày đặt hàng:</strong> " . date("d/m/Y H:i:s", strtotime($order['order_date'])) . "</p>";

            // Lấy các sản phẩm trong đơn hàng
            $order_id = $order['id'];
            $sql_order_items = "SELECT oi.product_id, oi.quantity, p.name, p.price 
                                FROM order_items oi 
                                JOIN products p ON oi.product_id = p.id 
                                WHERE oi.order_id = ?";
            $stmt_order_items = $conn->prepare($sql_order_items);
            $stmt_order_items->bind_param('i', $order_id);
            $stmt_order_items->execute();
            $result_order_items = $stmt_order_items->get_result();

            if ($result_order_items->num_rows > 0) {
                echo "<h6 class='mt-4 font-semibold'>Sản phẩm trong đơn hàng:</h6>";
                echo "<ul class='list-disc pl-5'>";
                while ($item = $result_order_items->fetch_assoc()) {
                    echo "<li>" . $item['name'] . " - Số lượng: " . $item['quantity'] . " - Giá: " . number_format($item['price'], 0, ',', '.') . " VND</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Không có sản phẩm trong đơn hàng này.</p>";
            }

            echo "</div>";  // Đóng div card-body
            echo "</div>";  // Đóng div card
        }
    } else {
        echo "<p>Chưa có đơn hàng nào được ghi nhận.</p>";
    }
    ?>

    <p><a href="shop_user.php" class="btn btn-secondary px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Quay lại trang chủ</a></p>
</div>

<?php include './component/footer.php'; ?> 
</body>
</html>

<?php
// Đóng kết nối
$stmt_orders->close();
$conn->close();
?>
