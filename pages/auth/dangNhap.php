<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/khachHang.css">

</head>

<body>

    <div class="container login-container">
        <div class="card login-card">

            <div class="text-center">
                <h2 class="login-title">Đăng nhập</h2>
            </div>

            <form>
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="text" class="form-control" id="username" placeholder="">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" placeholder="">
                </div>

                <div class="d-flex mb-4">
                    <a href="#" class="register-login-link">Chưa có tài khoản? Đăng ký ngay!</a>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login">Đăng nhập</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
