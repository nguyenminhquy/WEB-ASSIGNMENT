<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
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

// Lấy danh sách sản phẩm trong giỏ hàng của người dùng
$sql = "SELECT p.name, p.price, c.quantity, (p.price * c.quantity) AS total_price 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Tính tổng tiền của giỏ hàng
$total_cart_value = 0;
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
<?php include './component/header_user_home.php'; ?>
<!-- hero area -->
<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							
							<h1>KIỂM TRA GIỎ HÀNG CỦA BẠN NÀO ! -NHANH TAY MUA NGAY MÓN MỚI  </h1>
                            <p class="subtitle">Những món ăn hấp dẫn đang chờ bạn  </p>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->


    <div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <h2 class="text-center mb-4 text-uppercase font-weight-bold">Giỏ Hàng</h2>

            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered shadow-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Tên Sản Phẩm</th>
                                <th class="text-center">Giá</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-center">Tổng Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($row['name']); ?></td>
                                    <td class="text-center"><?= number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
                                    <td class="text-center"><?= $row['quantity']; ?></td>
                                    <td class="text-center"><?= number_format($row['total_price'], 0, ',', '.'); ?> VNĐ</td>
                                </tr>
                                <?php $total_cart_value += $row['total_price']; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <h4 class="font-weight-bold">Tổng Tiền Giỏ Hàng:</h4>
                    <h4 class="font-weight-bold"><?= number_format($total_cart_value, 0, ',', '.'); ?> VNĐ</h4>
                </div>

                <div class="d-flex justify-content-end mt-3">
    <a href="./checkout.php" class="btn btn-success btn-lg me-3 custom-btn">Thanh Toán</a>
    <a href="./shop_user.php" class="btn btn-primary btn-lg custom-btn">Tiếp tục mua sắm</a>
</div>

<style>
    .custom-btn {
        padding: 15px 30px;
        font-size: 1.2rem;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .custom-btn:focus {
        outline: none;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.7);
    }

    .custom-btn:active {
        transform: scale(0.98);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

            <?php else: ?>
                <p class="text-center">Giỏ hàng của bạn hiện tại chưa có sản phẩm nào!</p>
                <div class="d-flex justify-content-center mt-4">
                    <a href="./shop_user.php" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<?php include './component/footer.php' ?>
</body>
</html>

<?php
// Đóng kết nối
$stmt->close();
$conn->close();
?>
