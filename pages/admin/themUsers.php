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
                            <select name="vaiTro" id="vaiTroSelect" class="form-select" required
                                onchange="toggleRoleFields()">
                                <option value="Khách hàng" <?= ($user['vaiTro'] ?? '') === 'Khách hàng' ? 'selected' : '' ?>>Khách hàng</option>
                                <option value="Nhà phân phối tour" <?= ($user['vaiTro'] ?? '') === 'Nhà phân phối tour' ? 'selected' : '' ?>>Nhà phân phối</option>
                                <option value="Quản trị viên" <?= ($user['vaiTro'] ?? '') === 'Quản trị viên' ? 'selected' : '' ?>>Quản trị viên</option>
                            </select>
                        </div>

                        <!-- Chỉ hiện khi là Khách hàng -->
                        <?php if (!$editId || $user['vaiTro'] === 'Khách hàng'): ?>
                            <div id="khachHangFields">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Địa chỉ</strong></label>
                                    <input type="text" name="diaChi" class="form-control"
                                        value="<?= htmlspecialchars($user['diaChi'] ?? '') ?>">
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Chỉ hiện khi là NPP -->
                        <?php if (!$editId || $user['vaiTro'] === 'Nhà phân phối tour'): ?>
                            <div id="nppFields">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Tên công ty</strong></label>
                                    <input type="text" name="tenCongTy" class="form-control"
                                        value="<?= htmlspecialchars($user['tenCongTy'] ?? '') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Địa chỉ công ty</strong></label>
                                    <input type="text" name="diaChiCongTy" class="form-control"
                                        value="<?= htmlspecialchars($user['diaChiCongTy'] ?? '') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Tỷ lệ hoa hồng (%)</strong></label>
                                    <input type="number" name="tyLeHoaHong" class="form-control"
                                        min="0" max="100" step="0.01"
                                        value="<?= htmlspecialchars($user['tyLeHoaHong'] ?? '85') ?>"
                                        placeholder="VD: 85 (NPP hưởng 85% doanh thu)">
                                </div>
                            </div>
                        <?php endif; ?>

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
    <script>
        function toggleRoleFields() {
            const vaiTro = document.getElementById('vaiTroSelect').value;

            const khachHangFields = document.getElementById('khachHangFields');
            const nppFields = document.getElementById('nppFields');

            khachHangFields.style.display = vaiTro === 'Khách hàng' ? 'block' : 'none';
            nppFields.style.display = vaiTro === 'Nhà phân phối tour' ? 'block' : 'none';
        }

        // Chạy ngay khi load trang để ẩn/hiện đúng nếu đang edit
        toggleRoleFields();
    </script>
</body>

</html>