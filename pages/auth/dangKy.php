<?php 
    session_start()
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/khachHang.css">

</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <div class="container login-container">
        <div class="card login-card position-relative">

            <div class="text-center">
                <h2 class="login-title">Đăng Ký</h2>
            </div>

            <form action="../../actions/signUp.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="hoTen" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="tel" name="soDienThoai" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="matKhau" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nhập lại mật khẩu</label>
                    <input type="password" name="confirmMatKhau" class="form-control" required>
                </div>

                <div class="d-flex mb-4">
                    <a href="dangNhap.php" class="register-login-link">
                        Đã có tài khoản? Đăng nhập ngay!
                    </a>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login">Đăng ký</button>
                </div>

            </form>
            <?php 
            if (isset($_SESSION['error'])): ?>
                <p style="color:red;">
                    <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                    ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
</body>

</html>