<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

// Kiểm tra chế độ edit hay thêm mới
$editId = $_GET['edit'] ?? null;
$user = null;

if ($editId) {
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE maND = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if (!$user) {
        header('Location: quanLyUsers.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm người dùng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include "../../includes/sideBar-admin.php"; ?>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">
                <h3 class="mb-4 text-title">
                    Thêm người dùng
                </h3>
                <hr>

                <?php if (!empty($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?= match ($_GET['error']) {
                            'email_ton_tai' => 'Email đã tồn tại.',
                            'thieu_thong_tin' => 'Vui lòng điền đầy đủ thông tin.',
                            default => 'Lỗi hệ thống.'
                        } ?>
                    </div>
                <?php endif; ?>

                <div class="content-box">
                    <form action="../../actions/user/<?= $editId ? 'adminUpdateUser.php' : 'addUser.php' ?>"
                        method="POST">
                        <?php if ($editId): ?>
                            <input type="hidden" name="maND" value="<?= $editId ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label"><strong>Họ tên</strong></label>
                            <input type="text" name="hoTen" class="form-control"
                                value="<?= htmlspecialchars($user['hoTen'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Email</strong></label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Số điện thoại</strong></label>
                            <input type="text" name="soDienThoai" class="form-control"
                                value="<?= htmlspecialchars($user['soDienThoai'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Mật khẩu
                                    <?= $editId ? '<small class="text-muted">(để trống nếu không đổi)</small>' : '' ?>
                                </strong></label>
                            <input type="password" name="matKhau" class="form-control" <?= $editId ? '' : 'required' ?>>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Vai trò</strong></label>
                            <select name="vaiTro" class="form-select" required>
                                <option value="Khách hàng" <?= ($user['vaiTro'] ?? '') === 'Khách hàng' ? 'selected' : '' ?>>Khách hàng</option>
                                <option value="Nhà phân phối tour" <?= ($user['vaiTro'] ?? '') === 'Nhà phân phối tour' ? 'selected' : '' ?>>Nhà phân phối</option>
                                <option value="Quản trị viên" <?= ($user['vaiTro'] ?? '') === 'Quản trị viên' ? 'selected' : '' ?>>Quản trị viên</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="quanLyUsers.php" class="btn btn-secondary">← Quay lại</a>
                            <button type="submit" class="btn btn-primary">
                                <?= $editId ? 'Lưu thay đổi' : 'Thêm người dùng' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>