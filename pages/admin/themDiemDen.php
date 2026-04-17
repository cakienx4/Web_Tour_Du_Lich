<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$editId = $_GET['edit'] ?? null;
$dd = null;

if ($editId) {
    $stmt = $mysqli->prepare("SELECT * FROM diemden WHERE maDiemDen = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $dd = $stmt->get_result()->fetch_assoc();
    if (!$dd) {
        header('Location: quanLyDiemDen.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $editId ? 'Sửa điểm đến' : 'Thêm điểm đến' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "../../includes/sideBar-admin.php"; ?>

        <div class="col-md-9 col-lg-10 p-4">
            <h3 class="mb-4 text-title"><?= $editId ? 'Sửa điểm đến' : 'Thêm điểm đến' ?></h3>
            <hr>

            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?= match($_GET['error']) {
                        'thieu_thong_tin' => 'Vui lòng điền đầy đủ thông tin.',
                        'loi_upload'      => 'Lỗi khi tải ảnh lên.',
                        default           => 'Lỗi hệ thống.'
                    } ?>
                </div>
            <?php endif; ?>

            <div class="content-box">
                <form action="../../actions/diemDen/<?= $editId ? 'updateDiemDen.php' : 'createDiemDen.php' ?>" method="POST" enctype="multipart/form-data">
                    <?php if ($editId): ?>
                        <input type="hidden" name="maDiemDen" value="<?= $editId ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label"><strong>Tên điểm đến</strong></label>
                        <input type="text" name="tenDiemDen" class="form-control"
                            value="<?= htmlspecialchars($dd['tenDiemDen'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Vùng miền</strong></label>
                        <select name="vungMien" class="form-select" required>
                            <option value="">-- Chọn vùng miền --</option>
                            <option value="Bắc"   <?= ($dd['vungMien'] ?? '') === 'Bắc'   ? 'selected' : '' ?>>Miền Bắc</option>
                            <option value="Trung" <?= ($dd['vungMien'] ?? '') === 'Trung' ? 'selected' : '' ?>>Miền Trung</option>
                            <option value="Nam"   <?= ($dd['vungMien'] ?? '') === 'Nam'   ? 'selected' : '' ?>>Miền Nam</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Mô tả</strong></label>
                        <textarea name="moTa" class="form-control" rows="4"><?= htmlspecialchars($dd['moTa'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Ảnh điểm đến</strong>
                            <?= $editId ? '<small class="text-muted">(để trống nếu không đổi)</small>' : '' ?>
                        </label>
                        <?php if ($editId && !empty($dd['anhDiemDen'])): ?>
                            <div class="mb-2">
                                <img src="../../assets/img/diemden/<?= htmlspecialchars($dd['anhDiemDen']) ?>"
                                    style="height:100px; object-fit:cover; border-radius:6px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="anhDiemDen" class="form-control" accept="image/*"
                            <?= $editId ? '' : 'required' ?>>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="quanLyDiemDen.php" class="btn btn-secondary">← Quay lại</a>
                        <button type="submit" class="btn btn-primary">
                            <?= $editId ? 'Lưu thay đổi' : 'Thêm điểm đến' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>