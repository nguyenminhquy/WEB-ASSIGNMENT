<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_query = "";
if (isset($_GET['search_order_id']) && !empty($_GET['search_order_id'])) {
    $search_query = "AND o.id = " . $_GET['search_order_id'];
}
if (isset($_GET['search_payment_method']) && !empty($_GET['search_payment_method'])) {
    $search_query .= " AND o.payment_method LIKE '%" . $_GET['search_payment_method'] . "%'";
}

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
	<link rel="stylesheet" href="../../user_view/assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="../../user_view/assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="../../user_view/assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="../../user_view/assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="../../user_view/assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="../../user_view/assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="../../user_view/assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="../../user_view/assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
    <h2 class="text-2xl font-semibold mb-4">Lịch sử đơn hàng của bạn</h2>

 

    <?php
$orders_per_page = 5;

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($current_page - 1) * $orders_per_page;

$sql_orders = "SELECT * FROM orders LIMIT $orders_per_page OFFSET $offset";
$result_orders = $conn->query($sql_orders);

if ($result_orders->num_rows > 0) {
    while ($order = $result_orders->fetch_assoc()) {
        echo "<div class='card mb-4 shadow-lg rounded-lg overflow-hidden'>";
        echo "<div class='card-body bg-light'>";
        echo "<h5 class='card-title text-xl font-bold text-primary'>Đơn hàng #" . $order['id'] . "</h5>";
        echo "<p><strong>Tổng tiền:</strong> " . number_format($order['total_amount'], 0, ',', '.') . " VND</p>";
        echo "<p><strong>Phương thức thanh toán:</strong> " . $order['payment_method'] . "</p>";
        echo "<p><strong>Ngày đặt hàng:</strong> " . date("d/m/Y H:i:s", strtotime($order['order_date'])) . "</p>";

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
            echo "<h6 class='mt-4 font-semibold text-info'>Sản phẩm trong đơn hàng:</h6>";
            echo "<ul class='list-unstyled space-y-4'>";  
        
            while ($item = $result_order_items->fetch_assoc()) {
                echo "<li class='flex justify-between items-center p-4 border rounded-lg shadow-md bg-white hover:bg-gray-50 transition duration-300 ease-in-out transform hover:scale-105'>";
                echo "<span class='text-lg font-semibold'>" . $item['name'] . "</span>";
                echo "<span class='badge bg-green-500 text-white px-3 py-1 rounded-full'>" . "Số lượng: " . $item['quantity'] . "</span>";
                echo "<span class='badge bg-yellow-500 text-dark px-3 py-1 rounded-full'>" . number_format($item['price'], 0, ',', '.') . " VND</span>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='text-danger font-medium'>Không có sản phẩm trong đơn hàng này.</p>";
        }
        
        echo "</div>";  
        echo "</div>";  
    }
} else {
    echo "<p class='text-danger'>Không có đơn hàng nào.</p>";
}

$sql_count = "SELECT COUNT(*) AS total_orders FROM orders";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_orders = $row_count['total_orders'];

$total_pages = ceil($total_orders / $orders_per_page);

echo "<div class='pagination mt-4'>";
if ($current_page > 1) {
    echo "<a href='?page=" . ($current_page - 1) . "' class='btn btn-info'>Trước</a>";
}

for ($page = 1; $page <= $total_pages; $page++) {
    if ($page == $current_page) {
        echo "<span class='btn btn-secondary'>" . $page . "</span>";
    } else {
        echo "<a href='?page=" . $page . "' class='btn btn-outline-info'>" . $page . "</a>";
    }
}

if ($current_page < $total_pages) {
    echo "<a href='?page=" . ($current_page + 1) . "' class='btn btn-info'>Tiếp theo</a>";
}
echo "</div>";

?>



<p>
    <a href="./shop_user.php" class="btn btn-secondary px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Quay lại trang chủ
    </a>
</p>

</div>

<?php include '../component/footer.php'; ?> 
</body>
</html>

<?php
$stmt_orders->close();
$conn->close();
?>
