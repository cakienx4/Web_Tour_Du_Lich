<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$tuNgay  = $_GET['tuNgay'] ?? '';
$denNgay = $_GET['denNgay'] ?? '';
$maNPP   = $_GET['maNPP'] ?? '';

// Điều kiện lọc theo ngày và NPP
$whereClause = "WHERE dd.trangThaiTT IN ('daThanhToan', 'Hết hạn')";
$params = [];
$types  = '';

if ($tuNgay) {
    $whereClause .= " AND dd.thoiGianThanhToan >= ?";
    $params[] = $tuNgay;
    $types   .= 's';
}
if ($denNgay) {
    $whereClause .= " AND dd.thoiGianThanhToan <= ?";
    $params[] = $denNgay;
    $types   .= 's';
}
if ($maNPP) {
    $whereClause .= " AND t.maND = ?";
    $params[] = $maNPP;
    $types   .= 'i';
}

// Tổng doanh thu
$sqlTong = "SELECT SUM(dd.tongTien) AS tongDoanhThu,
                   COUNT(dd.maDon) AS tongDon,
                   COUNT(DISTINCT dd.maTour) AS tongTour,
                   SUM(dd.tongTien * (1 - u.tyLeHoaHong / 100)) AS doanhThuHeThong
            FROM dondat dd
            JOIN tour t ON dd.maTour = t.maTour
            JOIN user u ON t.maND = u.maND
            $whereClause";
$stmt = $mysqli->prepare($sqlTong);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$tongKe = $stmt->get_result()->fetch_assoc();

// Doanh thu theo NPP
$sqlNPP = "SELECT u.maND, u.hoTen, u.tyLeHoaHong,
                  COUNT(DISTINCT t.maTour) AS soTour,
                  COUNT(dd.maDon) AS soDon,
                  SUM(dd.tongTien) AS tongDoanhThu,
                  SUM(dd.tongTien * u.tyLeHoaHong / 100) AS doanhThuNPP,
                  SUM(dd.tongTien * (1 - u.tyLeHoaHong / 100)) AS doanhThuHeThong
           FROM dondat dd
           JOIN tour t ON dd.maTour = t.maTour
           JOIN user u ON t.maND = u.maND
           $whereClause
           GROUP BY u.maND, u.hoTen, u.tyLeHoaHong
           ORDER BY tongDoanhThu DESC";
$stmt = $mysqli->prepare($sqlNPP);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$dsNPP = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Danh sách NPP cho dropdown filter
$stmtNPP = $mysqli->prepare("SELECT maND, hoTen FROM user WHERE vaiTro = 'Nhà phân phối tour' ORDER BY hoTen ASC");
$stmtNPP->execute();
$dsDSNPP = $stmtNPP->get_result()->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thống kê doanh thu</title>
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
                <h3 class="mb-4 text-title">Thống kê doanh thu</h3>

                <hr>

                <div class="content-box mb-4">
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Từ ngày</label>
                                <input type="date" name="tuNgay" class="form-control" value="<?= htmlspecialchars($tuNgay) ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Đến ngày</label>
                                <input type="date" name="denNgay" class="form-control" value="<?= htmlspecialchars($denNgay) ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nhà phân phối</label>
                                <select name="maNPP" class="form-select">
                                    <option value="">Tất cả</option>
                                    <?php foreach ($dsDSNPP as $npp): ?>
                                        <option value="<?= $npp['maND'] ?>" <?= $maNPP == $npp['maND'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($npp['hoTen']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Lọc</button>
                            </div>
                            <?php if ($tuNgay || $denNgay || $maNPP): ?>
                                <div class="col-md-1 d-flex align-items-end">
                                    <a href="thongKeHeThong.php" class="btn btn-outline-danger w-100">Xóa lọc</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="content-box text-center">
                            <h6>Tổng doanh thu</h6>
                            <h4 class="text-success">
                                <?= number_format($tongKe['tongDoanhThu'] ?? 0, 0, ',', '.') ?>đ
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="content-box text-center">
                            <h6>Tổng số đơn</h6>
                            <h4><?= $tongKe['tongDon'] ?? 0 ?></h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="content-box text-center">
                            <h6>Số tour đã bán</h6>
                            <h4><?= $tongKe['tongTour'] ?? 0 ?></h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="content-box text-center">
                            <h6>Doanh thu hệ thống</h6>
                            <h4 class="text-primary">
                                <?= number_format($tongKe['doanhThuHeThong'] ?? 0, 0, ',', '.') ?>đ
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- TABLE DOANH THU -->
                <div class="content-box">

                    <h5 class="mb-3">Doanh thu theo nhà phân phối</h5>

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nhà phân phối</th>
                                <th>Tỷ lệ HH</th>
                                <th>Số tour</th>
                                <th>Số đơn</th>
                                <th>Tổng doanh thu</th>
                                <th>NPP hưởng</th>
                                <th>Hệ thống hưởng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($dsNPP)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Không có dữ liệu.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($dsNPP as $npp): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($npp['hoTen']) ?></td>
                                        <td><?= $npp['tyLeHoaHong'] ?>%</td>
                                        <td><?= $npp['soTour'] ?></td>
                                        <td><?= $npp['soDon'] ?></td>
                                        <td><?= number_format($npp['tongDoanhThu'] ?? 0, 0, ',', '.') ?>đ</td>
                                        <td class="text-success"><?= number_format($npp['doanhThuNPP'] ?? 0, 0, ',', '.') ?>đ</td>
                                        <td class="text-primary"><?= number_format($npp['doanhThuHeThong'] ?? 0, 0, ',', '.') ?>đ</td>
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