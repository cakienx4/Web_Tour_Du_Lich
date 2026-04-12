<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header">
    <div class="container_header">

        <div class="logo">
            <a href="../../pages/khachHang/trangChu.php">
                <img src="../../assets/img/TAVIVU_Logo.png">
            </a>
        </div>

        <nav class="main-nav">
            <ul>
                <li><a href="../../pages/khachHang/tour.php">Tours</a></li>
                <li><a href="../../pages/khachHang/diemDen.php">Điểm đến</a></li>
                <li><a href="../../pages/khachHang/gioiThieu.php">Giới thiệu</a></li>
                <li><a href="#footer-section">Liên hệ</a></li>
            </ul>
        </nav>

        <div class="login">

            <?php if (isset($_SESSION['maND'])): ?>
                <div class="user-info">
                    <span style="color:white;">
                        Xin chào,
                    </span>
                    <span style="color:white;">
                        <?php echo $_SESSION['hoTen']; ?>
                    </span>
                </div>
                <a href="../../pages/khachHang/hoSo.php" class="login-btn">Hồ sơ</a>
                <a href="../../actions/logout.php" class="login-btn">Đăng xuất</a>

            <?php else: ?>

                <a href="../../pages/auth/dangNhap.php" class="login-btn">Đăng nhập</a>
                <a href="../../pages/auth/dangKy.php" class="login-btn">Đăng ký</a>

            <?php endif; ?>

        </div>

        <div class="phone-num">
            <p>📞 0123 456 789</p>
        </div>

    </div>
</header>