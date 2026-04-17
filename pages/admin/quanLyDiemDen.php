<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

// Tìm kiếm + lọc
$search = trim($_GET['search'] ?? '');
$vungMien = $_GET['vungMien'] ?? '';

$sql = "SELECT * FROM diemden WHERE 1=1";
$params = [];
$types = '';

if ($search) {
    $sql .= " AND tenDiemDen LIKE ?";
    $params[] = "%$search%";
    $types .= 's';
}

if ($vungMien && in_array($vungMien, ['Bắc', 'Trung', 'Nam'])) {
    $sql .= " AND vungMien = ?";
    $params[] = $vungMien;
    $types .= 's';
}

$sql .= " ORDER BY maDiemDen ASC";
$stmt = $mysqli->prepare($sql);
if ($params)
    $stmt->bind_param($types, ...$params);
$stmt->execute();
$dsDiemDen = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý điểm đến</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php include "../../includes/sideBar-admin.php"; ?>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <!-- TITLE -->
                <h3 class="mb-4 text-title">Quản lý điểm đến</h3>

                <hr>

                <?php if (!empty($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?= match ($_GET['success']) {
                            'them_moi' => 'Thêm điểm đến thành công!',
                            'cap_nhat' => 'Cập nhật điểm đến thành công!',
                            'xoa' => 'Xóa điểm đến thành công!',
                            default => 'Thao tác thành công!'
                        } ?>
                    </div>
                <?php endif; ?>
                
                <!-- FILTER + ADD -->
                <div class="content-box mb-3">
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label">Tìm kiếm</label>
                                <input type="text" name="search" class="form-control" placeholder="Tên điểm đến..."
                                    value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Vùng miền</label>
                                <select name="vungMien" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="Bắc" <?= $vungMien === 'Bắc' ? 'selected' : '' ?>>Miền Bắc</option>
                                    <option value="Trung" <?= $vungMien === 'Trung' ? 'selected' : '' ?>>Miền Trung
                                    </option>
                                    <option value="Nam" <?= $vungMien === 'Nam' ? 'selected' : '' ?>>Miền Nam</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-secondary w-100">Lọc</button>
                            </div>
                            <div class="col-md-2 text-end d-flex align-items-end">
                                <a href="themDiemDen.php" class="btn btn-primary w-100">Thêm điểm đến</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tên điểm đến</th>
                                <th>Vùng miền</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($dsDiemDen)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Không tìm thấy điểm đến nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($dsDiemDen as $dd): ?>
                                    <tr>
                                        <td>
                                            <?= $dd['maDiemDen'] ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($dd['tenDiemDen']) ?>
                                        </td>
                                        <td>Miền
                                            <?= htmlspecialchars($dd['vungMien']) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars(mb_strimwidth($dd['moTa'], 0, 60, '...')) ?>
                                        </td>
                                        <td>
                                            <a href="themDiemDen.php?edit=<?= $dd['maDiemDen'] ?>"
                                                class="btn btn-warning btn-sm">Sửa</a>
                                            <a href="../../actions/diemDen/deleteDiemDen.php?id=<?= $dd['maDiemDen'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Xóa điểm đến này?')">Xóa</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</body>

</html>