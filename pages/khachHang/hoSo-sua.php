<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hồ sơ của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/khachHang.css">

</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <div class="breadcrumb-box">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb tour-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link ">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">Trang hồ sơ</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container my-5">
        <div class="profile-box">
            <div class="profile-title">
                Chỉnh sửa hồ sơ
            </div>
            <form>
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" class="form-control" value="Nguyễn Văn A">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="nguyenvana@gmail.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" value="0988888888">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" value="123456">
                </div>
                <div class="text-end">
                    <button class="btn btn-success btn-edit">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</body>

</html>