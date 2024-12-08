
<link rel="stylesheet" href="../pages/css/sidebar.css">

<div class="dashboard-container">
    <h3 class="text-center">Dashboard</h3>
    <ul class="list-group">
        <!-- Quản lý người dùng -->
        <li class="list-group-item">
            <a href="#productMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">
                <i class="fas fa-users me-2"></i> Quản lý người dùng
            </a>
            <ul class="collapse list-unstyled" id="productMenu">
                <li><a href="product_list.php">Xem danh sách khách hàng</a></li>
                <li><a href="add_product.php">Xem danh sách nhân viên</a></li>
                <li><a href="delete_user.php">Xóa nhân viên</a></li>
                <li><a href="edit_user.php">Chỉnh sửa thông tin sinh viên</a></li>
            </ul>
        </li>

        <!-- Quản lý đơn hàng -->
        <li class="list-group-item">
            <a href="#orderMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">
                <i class="fas fa-shopping-cart me-2"></i> Quản lý đơn hàng
            </a>
            <ul class="collapse list-unstyled" id="orderMenu">
                <li><a href="orders_list.php">Xem đơn hàng</a></li>
                <li><a href="./pending_orders.php">Danh sách đơn hàng đang chờ xử lý </a></li>
                <li><a href="./canceled_orders.php">Danh sách đơn hàng bị hủy  </a></li>
                <li><a href="./overtime_orders.php">Danh sách đơn hàng đang chờ lâu  </a></li>
                
            </ul>
        </li>

        <!-- Quản lý sản phẩm -->
        <li class="list-group-item">
            <a href="#productManagementMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">
                <i class="fas fa-box-open me-2"></i> Quản lý sản phẩm
            </a>
            <ul class="collapse list-unstyled" id="productManagementMenu">
                <li><a href="product_list.php">Xem danh sách sản phẩm</a></li>
                <li><a href="add_product.php">Thêm sản phẩm mới</a></li>
                <li><a href="edit_product.php">Chỉnh sửa sản phẩm</a></li>
                <li><a href="delete_product.php">Xóa sản phẩm</a></li>
            </ul>
        </li>

        <!-- Quản lý bình luận và đánh giá -->
        <li class="list-group-item">
            <a href="#feedbackMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">
                <i class="fas fa-comments me-2"></i> Quản lý bình luận & đánh giá
            </a>
            <ul class="collapse list-unstyled" id="feedbackMenu">
                <li><a href="view_comments.php" class="d-block ps-3 py-1">Xem bình luận</a></li>
                <li><a href="./view_comment_product.php" class="d-block ps-3 py-1">Xem bình luận theo từng sản phẩm</a></li>
                <li><a href="./view_comment_user.php" class="d-block ps-3 py-1">Xem bình luận theo từng khách hàng </a></li>
                
                <li><a href="delete_feedback.php" class="d-block ps-3 py-1">Xóa bình luận & đánh giá</a></li>
            </ul>
        </li>

        <!-- Thông tin người dùng -->
        <li class="list-group-item">
            <a href="#userMenu" data-bs-toggle="collapse" aria-expanded="false" class="d-block">
                <i class="fas fa-user-circle me-2"></i> Thông tin người dùng
            </a>
            <ul class="collapse list-unstyled" id="userMenu">
                <li><a href="users_list.php">Thông tin cá nhân</a></li>
                <li><a href="user_settings.php">Cài đặt</a></li>
            </ul>
        </li>

        <!-- Đăng xuất -->
        <li class="list-group-item">
            <a href="../../user_view/pages/logout.php" class="d-block">
                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
            </a>
        </li>
    </ul>
</div>

