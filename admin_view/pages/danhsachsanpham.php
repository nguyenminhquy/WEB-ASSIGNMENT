<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Thay đổi nếu cần
$password = "";      // Thay đổi nếu cần
$dbname = "food_web"; // Thay đổi tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM products"; // Thay đổi tên bảng nếu cần
$result = $conn->query($sql);
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
	<link rel="shortcut icon" type="image/png" href="../../frutika-master/assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	
    <link rel="stylesheet" href="../../user/assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="../../user/frutika-master/assets/css/assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="../../frutika-master/assets/css/assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="../../frutika-master/assets/css/assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="../../frutika-master/assets/css/assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="../../frutika-master/assets/css/assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="../../frutika-master/assets/css/assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="../../frutika-master/assets/css/assets/css/responsive.css">

</head>


<body>
<?php include './component/preloader.php'; ?>
<?php include '../../frutika-master/'; ?>
	<?php include './component/header_user_home.php'; ?>
	<?php include './search_area.php'; ?>
	<?php include './component/hero_area_shop.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center text-primary">Danh Sách Món Ăn</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Món</th>
                    <th>Giá</th>
                    <th>Mô Tả</th>
                    <th>Hình Ảnh</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kiểm tra nếu có dữ liệu
                if ($result->num_rows > 0) {
                    // Lặp qua dữ liệu và hiển thị
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['name'] . "</td>
                                <td>" . number_format($row['price'], 0, ',', '.') . " VNĐ</td>
                                <td>" . $row['description'] . "</td>
                                <td><img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' width='100' height='100'></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có món ăn nào.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
