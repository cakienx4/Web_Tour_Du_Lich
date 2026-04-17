<?php
session_start();
require_once '../../config/database.php';

$stmt = $mysqli->prepare("SELECT hoTen, email, soDienThoai, diaChi FROM user WHERE maND = ?");
$stmt->bind_param("i", $_SESSION['maND']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$mode = $_GET['mode'] ?? 'view';
?>

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
                        <a href="trangChu.php" class="breadcrumb-link">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item active">Hồ sơ của tôi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container my-5 py-4">
        <div class="profile-box">

            <?php if (!empty($_GET['success'])): ?>
                <div class="alert alert-success">Cập nhật thông tin thành công!</div>
            <?php endif; ?>
            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php if ($_GET['error'] === 'email_ton_tai'): ?>
                        Email đã được sử dụng bởi tài khoản khác.
                    <?php else: ?>
                        Lỗi hệ thống. Vui lòng thử lại.
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($mode === 'edit'): ?>
                <!-- CHẾ ĐỘ CHỈNH SỬA -->
                <div class="profile-title">Chỉnh sửa hồ sơ</div>
                <hr>
                <form action="../../actions/user/updateUser.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="hoTen" class="form-control" value="<?= htmlspecialchars($user['hoTen']) ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="soDienThoai" class="form-control"
                            value="<?= htmlspecialchars($user['soDienThoai']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="diaChi" class="form-control"
                            value="<?= htmlspecialchars($user['diaChi'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới <small class="text-muted">(để trống nếu không
                                đổi)</small></label>
                        <input type="password" name="matKhau" class="form-control">
                    </div>
                    <div class="text-end mt-4">
                        <a href="hoSo.php" class="btn btn-secondary me-2">Hủy</a>
                        <button type="submit" class="btn btn-success btn-edit">Lưu thông tin</button>
                    </div>
                </form>

            <?php else: ?>
                <!-- CHẾ ĐỘ XEM -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="profile-title mb-0">Hồ sơ của tôi</div>
                    <a href="lichSuDatTour.php" class="btn btn-outline-success">Lịch sử đặt tour</a>
                </div>
                <hr>
                <div class="profile-row">
                    <span class="profile-label">Họ tên</span>
                    <span class="profile-value"><?= htmlspecialchars($user['hoTen']) ?></span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">Email</span>
                    <span class="profile-value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">Số điện thoại</span>
                    <span class="profile-value"><?= htmlspecialchars($user['soDienThoai']) ?></span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">Địa chỉ</span>
                    <span class="profile-value">
                        <?= htmlspecialchars($user['diaChi'] ?? 'Chưa cập nhật') ?>
                    </span>
                </div>
                <div class="profile-row">
                    <span class="profile-label">Mật khẩu</span>
                    <span class="profile-value">******</span>
                </div>
                <div class="text-end">
                    <a href="hoSo.php?mode=edit" class="btn btn-primary btn-edit">Chỉnh sửa</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>