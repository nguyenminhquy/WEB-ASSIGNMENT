<?php  
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "food_web"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>
<html>
<head>
    <title>Danh sách sản phẩm</title>
    <link href="img/favicon.ico" rel="icon">
    <link rel="shortcut icon" type="image/png" href="../../assets/img/logo.jpg">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="justify-content-between align-items-center mb-4">
            <h1>Danh sách sản phẩm</h1>
            <button id="create-new" onclick="window.location.href='add_product.php'" class="btn btn-success">Thêm sản phẩm mới</button>
        </div>
        <table border="1" cellpadding='6' cellspacing='0' table table-striped table-hover table-bordered align-middle>
            <thead class="bg-light text-white text-center">
                <tr id="title-table">
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='text-center'>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . number_format($row['price'], 0, ',', '.') . " VNĐ</td>";
                        echo "<td><img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' width='100' height='100'></td>";
                        echo "<td>";
                        echo "<button id='delete' onclick=\"window.location.href='delete.php?product_id=" . $row['id'] . "'\">Xóa</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-muted';>Không có sản phẩm nào.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
