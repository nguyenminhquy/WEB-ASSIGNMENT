<!-- hero area -->
<div class="hero-area hero-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-2 text-center">
                <div class="hero-text">
                    <div class="hero-text-tablecell">
                        <p class="subtitle">THỨC ĂN HẤP DẪN </p>
                        <h1>CÓ PHẢI BẠN ĐANG ĐÓI KHÔNG ?</h1>
                        <div class="hero-btns">
                            <!-- Kiểm tra nếu người dùng đã đăng nhập -->
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="shop.php" class="boxed-btn">MUA NGAY THÔI</a>
                            <?php else: ?>
                                <a href="login.php" class="boxed-btn">ĐĂNG NHẬP ĐỂ MUA</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end hero area -->
