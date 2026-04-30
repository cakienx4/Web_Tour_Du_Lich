<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maND     = intval($_SESSION['maND']);
$tuNgay   = trim($_GET['tuNgay'] ?? '');
$denNgay  = trim($_GET['denNgay'] ?? '');
$tenTour  = trim($_GET['tenTour'] ?? '');
$maTourTim = trim($_GET['maTour'] ?? '');

// Lấy tỷ lệ hoa hồng của NPP này
$stmt = $mysqli->prepare("SELECT tyLeHoaHong FROM user WHERE maND = ?");
$stmt->bind_param('i', $maND);
$stmt->execute();
$tyLeHoaHong = floatval($stmt->get_result()->fetch_assoc()['tyLeHoaHong'] ?? 0);

$sql = "
    SELECT t.maTour, t.tenTour,
           COUNT(dd.maDon)       AS soDon,
           SUM(dd.soNguoi)       AS soKhach,
           SUM(dd.tongTien)      AS doanhThu
    FROM tour t
    JOIN dondat dd ON t.maTour = dd.maTour
    WHERE t.maND = ? AND dd.trangThaiTT = 'Đã thanh toán'
";
$params = [$maND];
$types  = 'i';

if (!empty($tuNgay)) {
    $sql .= " AND dd.thoiGianThanhToan >= ?";
    $params[] = $tuNgay . ' 00:00:00';
    $types .= 's';
}

if (!empty($denNgay)) {
    $sql .= " AND dd.thoiGianThanhToan <= ?";
    $params[] = $denNgay . ' 23:59:59';
    $types .= 's';
}

if (!empty($tenTour)) {
    $sql .= " AND t.tenTour LIKE ?";
    $params[] = "%$tenTour%";
    $types .= 's';
}

if (!empty($maTourTim)) {
    $sql .= " AND t.maTour = ?";
    $params[] = intval($maTourTim);
    $types .= 'i';
}

$sql .= " GROUP BY t.maTour ORDER BY doanhThu DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$dsThongKe = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Tính tổng
$tongDoanhThu = array_sum(array_column($dsThongKe, 'doanhThu'));
$tongDon      = array_sum(array_column($dsThongKe, 'soDon'));
$tongKhach    = array_sum(array_column($dsThongKe, 'soKhach'));
$thuNhapThuc  = $tongDoanhThu * $tyLeHoaHong / 100;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thống kê doanh thu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>
    <?php include "../../includes/sideBar-NPP.php"; ?>

    <div class="main-content p-4">

        <h3 class="mb-4 text-title">Thống kê doanh thu</h3>
        <hr>

        <!-- FILTER -->
        <div class="content-box mb-3">
            <form method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Từ ngày</label>
                        <input type="date" name="tuNgay" class="form-control"
                            value="<?= htmlspecialchars($tuNgay) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Đến ngày</label>
                        <input type="date" name="denNgay" class="form-control"
                            value="<?= htmlspecialchars($denNgay) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tên tour</label>
                        <input type="text" name="tenTour" class="form-control"
                            placeholder="Nhập tên tour"
                            value="<?= htmlspecialchars($tenTour) ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">ID tour</label>
                        <input type="number" name="maTour" class="form-control"
                            placeholder="Nhập mã tour"
                            value="<?= htmlspecialchars($maTourTim) ?>">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TỔNG QUAN -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="content-box text-center">
                    <h6>Tổng doanh thu</h6>
                    <h5 class="text-success"><?= number_format($tongDoanhThu, 0, ',', '.') ?>đ</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-box text-center">
                    <h6>Thu nhập thực nhận</h6>
                    <h5 class="text-primary"><?= number_format($thuNhapThuc, 0, ',', '.') ?>đ</h5>
                    <small class="text-muted">Tỷ lệ hoa hồng: <?= $tyLeHoaHong ?>%</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-box text-center">
                    <h6>Số đơn thành công</h6>
                    <h5><?= $tongDon ?></h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-box text-center">
                    <h6>Tổng số khách</h6>
                    <h5><?= $tongKhach ?></h5>
                </div>
            </div>
        </div>

        <!-- BẢNG DOANH THU -->
        <div class="content-box">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID Tour</th>
                        <th>Tên tour</th>
                        <th>Số đơn</th>
                        <th>Số khách</th>
                        <th>Doanh thu</th>
                        <th>Thu nhập thực nhận</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dsThongKe)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Không có dữ liệu.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dsThongKe as $tk): ?>
                            <tr>
                                <td><?= $tk['maTour'] ?></td>
                                <td><?= htmlspecialchars($tk['tenTour']) ?></td>
                                <td><?= $tk['soDon'] ?></td>
                                <td><?= $tk['soKhach'] ?></td>
                                <td><?= number_format($tk['doanhThu'], 0, ',', '.') ?>đ</td>
                                <td><?= number_format($tk['doanhThu'] * $tyLeHoaHong / 100, 0, ',', '.') ?>đ</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>