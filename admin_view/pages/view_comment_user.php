<?php
session_start();

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_web";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách người dùng
$sql_users = "SELECT DISTINCT user_name FROM comments";
$result_users = $conn->query($sql_users);

// Lọc bình luận theo người dùng
$user_name = isset($_GET['user_name']) ? $conn->real_escape_string($_GET['user_name']) : '';
$sql_comments = "SELECT c.id, c.comment_text, c.created_at, c.user_name, p.name AS product_name
                 FROM comments c
                 JOIN products p ON c.product_id = p.id";
if (!empty($user_name)) {
    $sql_comments .= " WHERE c.user_name = '$user_name'";
}
$sql_comments .= " ORDER BY c.created_at DESC";

$result_comments = $conn->query($sql_comments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Bình Luận Theo Người Dùng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Danh Sách Bình Luận Theo Người Dùng</h1>

    <!-- Bộ lọc người dùng -->
    <form action="" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-8">
                <select name="user_name" class="form-select">
                    <option value="">Tất cả người dùng</option>
                    <?php while ($user = $result_users->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($user['user_name']); ?>" <?= $user_name === $user['user_name'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($user['user_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm </button>
            </div>
        </div>
    </form>

    <!-- Hiển thị danh sách bình luận -->
    <?php if ($result_comments->num_rows > 0): ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên Người Dùng</th>
                    <th>Sản Phẩm</th>
                    <th>Bình Luận</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($comment = $result_comments->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($comment['id']); ?></td>
                        <td><?= htmlspecialchars($comment['user_name']); ?></td>
                        <td><?= htmlspecialchars($comment['product_name']); ?></td>
                        <td><?= htmlspecialchars($comment['comment_text']); ?></td>
                        <td><?= date("d/m/Y H:i:s", strtotime($comment['created_at'])); ?></td>
                        <td>
                            <form action="delete_comment.php" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                <input type="hidden" name="comment_id" value="<?= $comment['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Không có bình luận nào.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="./index.php" class="btn btn-primary">Quay Lại Dashboard</a>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
