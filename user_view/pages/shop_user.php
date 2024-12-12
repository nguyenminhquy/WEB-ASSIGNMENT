<?php
session_start();

$message = ''; 

if (!isset($_SESSION['user_id'])) {
    $message = "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $message = "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error;
    exit();
}

$sql_check = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param('ii', $user_id, $product_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $sql_update = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('iii', $quantity, $user_id, $product_id);
    $stmt_update->execute();
    $message = "Sản phẩm đã được thêm vào giỏ hàng!";
    $stmt_update->close();
} else {
    $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('iii', $user_id, $product_id, $quantity);
    $stmt_insert->execute();
    $message = "Sản phẩm đã được thêm vào giỏ hàng!";
    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
	<!-- title -->
	<title>THỨC ĂN NHÀ MÌNH </title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">

    <!-- CSS and other links -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    

</head>
<body>

    <!-- Header and main content -->
    <?php include '../component/preloader.php'; ?>
    <?php include '../component/header_user_home.php'; ?>
	<div class="shop-user-hero">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							
							<h1>HÃY ĐĂNG NHẬP ĐỄ BẮT ĐẦU MUA SẮM NHA !</h1>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



<style>
.shop-user-hero {
    background-image: url('../assets/img/breadcrumb-bg.jpg');
    background-size: cover;
    background-position: center center; 
    background-repeat: no-repeat; 
    height: 100vh; 
    display: flex;
    justify-content: center;
    align-items: center;
    color: white; 
}

.hero-text h1 {
    font-size: 3rem; 
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); 
    padding: 0; 
}

.hero-text-tablecell {
    display: inline-block;
    vertical-align: middle;
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem;
    }
}

.row.product-lists {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.single-product-item {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    height: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.single-product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.product-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

h3 {
    font-size: 1.2rem;
    margin: 10px 0;
}

.product-price {
    font-size: 1.1rem;
    color: #f76b1c;
    margin: 10px 0;
}

.cart-btn {
    display: inline-block;
    margin-top: auto; 
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}


.cart-btn:hover {
    background-color: #0056b3;
}


</style>


    <?php include '../component/product.card.php'; ?>
    <?php include '../component/footer.php'; ?>
    
    <script src="../assets/js/jquery-1.11.3.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
