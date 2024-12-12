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

$sql_user = "SELECT username, email, address, phone FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param('i', $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_info = $result_user->fetch_assoc();

$sql_cart = "SELECT p.name, p.price, c.quantity, (p.price * c.quantity) AS total_price 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param('i', $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

$total_cart_value = 0;
$cart_items = [];

while ($row = $result_cart->fetch_assoc()) {
    $cart_items[] = $row;
    $total_cart_value += $row['total_price'];
}

$stmt_user->close();
$stmt_cart->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>THỨC ĂN NHÀ MÌNH </title>

    <link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/checkout.css">
</head>
<body>
    <?php include '../component/header_user_home.php'; ?>
    <?php include '../component/hero_area_shop.php'; ?>

    <div class="container my-5">
    <h2 class="text-center mb-4">Thanh Toán</h2>

    <div id="error_message" class="alert alert-danger fade show" role="alert"></div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thông tin người dùng</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Tên:</strong>
                                <p class="mb-0"><?= htmlspecialchars($user_info['username']); ?></p>
                            </div>
                            <div class="mb-3">
                                <strong>Email:</strong>
                                <p class="mb-0"><?= htmlspecialchars($user_info['email']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Địa chỉ:</strong>
                                <p class="mb-0"><?= htmlspecialchars($user_info['address']); ?></p>
                            </div>
                            <div class="mb-3">
                                <strong>Số điện thoại:</strong>
                                <p class="mb-0"><?= htmlspecialchars($user_info['phone']); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="edit_profile.php" class="btn btn-primary btn-lg px-4 py-2" style="border-radius: 25px;">Chỉnh sửa thông tin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
        <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thông tin giỏ hàng </h4>
                </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped animate__animated animate__fadeIn">
                    <thead class="thead-light">
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Tổng Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr class="animate__animated animate__fadeIn animate__delay-1s">
                                <td><?= htmlspecialchars($item['name']); ?></td>
                                <td><?= number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                <td><?= $item['quantity']; ?></td>
                                <td><?= number_format($item['total_price'], 0, ',', '.'); ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <h5 class="text-right mt-3">Tổng Tiền Giỏ Hàng: <?= number_format($total_cart_value, 0, ',', '.'); ?> VNĐ</h5>
        </div>
    </div>

    <div class="row mb-4">
        
        <div class="col-md-12">
        <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Chọn Phương Thức Thanh Toán </h4>
                    
                </div>
          
            <form id="payment_form" action="process_payment.php" method="POST" class="bg-light p-4 rounded shadow-lg">
                <div class="form-group mb-4">
                    <label for="payment_method" class="h5">Phương thức thanh toán:</label>
                    <select class="form-control form-control-lg" id="payment_method" name="payment_method" required>
                        <option value="cash">Thanh toán tiền mặt khi nhận hàng</option>
                        <option value="credit_card">Thẻ tín dụng (Visa, MasterCard)</option>
                        <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                    </select>
                </div>

                <div class="form-group mb-4" id="bank_selection" style="display:none;">
                    <label for="bank" class="h5">Chọn Ngân Hàng:</label>
                    <select class="form-control form-control-lg" id="bank" name="bank" required>
                        <option value="vietcombank">Vietcombank</option>
                        <option value="techcombank">Techcombank</option>
                        <option value="bidv">BIDV</option>
                        <option value="acb">ACB</option>
                        <option value="vietnam_eximbank">VietinBank</option>
                        <option value="sacombank">Sacombank</option>
                        <option value="mbbank">MB Bank</option>
                        <option value="vib">VIB</option>
                        <option value="vpbank">VPBank</option>
                    </select>
                </div>

                <input type="hidden" name="total_amount" value="<?= $total_cart_value; ?>">

                <button type="submit" class="btn btn-success btn-block btn-lg mt-4">Xác Nhận Thanh Toán</button>
            </form>
        </div>
    </div>
</div>


    <?php include '../component/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('payment_form').addEventListener('submit', function(event) {
            if (<?= $total_cart_value ?> === 0) {
                var errorMessage = document.getElementById('error_message');
                errorMessage.textContent = "Giỏ hàng của bạn hiện tại không có sản phẩm. Vui lòng thêm sản phẩm vào giỏ hàng.";
                errorMessage.style.display = 'block'; 

                event.preventDefault();

                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 5000); 
            }
        });
        document.getElementById('payment_method').addEventListener('change', function() {
    var paymentMethod = this.value;
    var bankSelection = document.getElementById('bank_selection');

    if (paymentMethod === 'bank_transfer') {
        bankSelection.style.display = 'block';
    } else {
        bankSelection.style.display = 'none';
    }
});
        document.getElementById('payment_method').addEventListener('change', function() {
            var paymentMethod = this.value;
            var bankSelection = document.getElementById('bank_selection');

            if (paymentMethod === 'bank_transfer') {
                bankSelection.style.display = 'block';
            } else {
                bankSelection.style.display = 'none';
            }
        });
    </script>

</body>
</html>

<?php
$conn->close();
?>