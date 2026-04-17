<?php
session_start();
require_once '../../config/database.php';

// Check quyền
if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

// Lấy filter
$timKiem = $_GET['timKiem'] ?? '';
$maDon = $_GET['maDon'] ?? '';
$maTour = $_GET['maTour'] ?? '';
$trangThai = $_GET['trangThai'] ?? '';

// SQL
$sql = "
SELECT dd.*, 
       t.tenTour, 
       t.maTour,
       u.hoTen
FROM dondat dd
JOIN tour t ON dd.maTour = t.maTour
JOIN user u ON dd.maND = u.maND
WHERE 1=1
";

$params = [];
$types = "";

// Tìm kiếm theo tên KH hoặc tour
if (!empty($timKiem)) {
    $sql .= " AND (u.hoTen LIKE ? OR t.tenTour LIKE ?)";
    $params[] = "%$timKiem%";
    $params[] = "%$timKiem%";
    $types .= "ss";
}

// Lọc theo ID đơn
if (!empty($maDon)) {
    $sql .= " AND dd.maDon = ?";
    $params[] = $maDon;
    $types .= "i";
}

// Lọc theo tour
if (!empty($maTour)) {
    $sql .= " AND dd.maTour = ?";
    $params[] = $maTour;
    $types .= "i";
}

// Lọc trạng thái
if (!empty($trangThai) && $trangThai !== 'Tất cả') {
    $sql .= " AND dd.trangThaiTT = ?";
    $params[] = $trangThai;
    $types .= "s";
}

$sql .= " ORDER BY dd.maDon DESC";

$stmt = $mysqli->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$dondats = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn đặt tour</title>
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
                <h3 class="mb-4 text-title">Quản lý đơn đặt tour</h3>

                <hr>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <form method="GET">
                        <div class="row">

                            <div class="col-md-4">
                                <label><strong>Tìm kiếm</strong></label>
                                <input type="text" name="timKiem" class="form-control"
                                    value="<?= htmlspecialchars($timKiem) ?>">
                            </div>

                            <div class="col-md-2">
                                <label><strong>ID đơn</strong></label>
                                <input type="text" name="maDon" class="form-control"
                                    value="<?= htmlspecialchars($maDon) ?>">
                            </div>

                            <div class="col-md-2">
                                <label><strong>ID Tour</strong></label>
                                <input type="text" name="maTour" class="form-control"
                                    value="<?= htmlspecialchars($maTour) ?>">
                            </div>

                            <div class="col-md-3">
                                <label><strong>Trạng thái</strong></label>
                                <select name="trangThai" class="form-select">
                                    <option>Tất cả</option>
                                    <option <?= $trangThai == 'Chờ thanh toán' ? 'selected' : '' ?>>Chờ thanh toán</option>
                                    <option <?= $trangThai == 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
                                    <option <?= $trangThai == 'Đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
                                    <option <?= $trangThai == 'Hết hạn' ? 'selected' : '' ?>>Hết hạn</option>
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Lọc</button>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID đơn</th>
                                <th>ID tour</th>
                                <th>Khách hàng</th>
                                <th>Tour</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Phương thức</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($don = $dondats->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?= $don['maDon'] ?>
                                    </td>
                                    <td>
                                        <?= $don['maTour'] ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($don['hoTen']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($don['tenTour']) ?>
                                    </td>

                                    <td>
                                        <?= date('d/m/Y', strtotime($don['thoiGianDat'])) ?>
                                    </td>

                                    <td>
                                        <?= number_format($don['tongTien'], 0, ',', '.') ?>đ
                                    </td>

                                    <td>
                                        <?= $don['phuongThucTT'] ?? '-' ?>
                                    </td>

                                    <td>
                                        <?php if ($don['trangThaiTT'] === 'Đã thanh toán'): ?>
                                            <span class="badge bg-success">Đã thanh toán</span>
                                        <?php elseif ($don['trangThaiTT'] === 'Chờ thanh toán'): ?>
                                            <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                                        <?php elseif ($don['trangThaiTT'] === 'Đã hủy'): ?>
                                            <span class="badge bg-danger">Đã hủy</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Hết hạn</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="chiTietDon.php?maDon=<?= $don['maDon'] ?>"
                                            class="btn btn-info btn-sm">Xem</a>

                                        <a href="../../actions/donDat/updateStatus.php?maDon=<?= $don['maDon'] ?>"
                                            class="btn btn-primary btn-sm">
                                            Cập nhật
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</body>

</html>