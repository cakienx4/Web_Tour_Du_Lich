<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maND = intval($_SESSION['maND']);

$timKiem   = trim($_GET['timKiem'] ?? '');
$maDonTim  = trim($_GET['maDon'] ?? '');
$maTourTim = trim($_GET['maTour'] ?? '');
$trangThai = trim($_GET['trangThai'] ?? '');

$sql = "
    SELECT dd.maDon, dd.maTour, dd.thoiGianDat, dd.soNguoi, dd.tongTien,
           dd.phuongThucTT, dd.trangThaiTT,
           u.hoTen AS tenKhach,
           t.tenTour
    FROM dondat dd
    JOIN user u ON dd.maND = u.maND
    JOIN tour t ON dd.maTour = t.maTour
    WHERE t.maND = ?
";
$params = [$maND];
$types  = 'i';

if (!empty($timKiem)) {
    $sql .= " AND (u.hoTen LIKE ? OR t.tenTour LIKE ?)";
    $params[] = "%$timKiem%";
    $params[] = "%$timKiem%";
    $types .= 'ss';
}

if (!empty($maDonTim)) {
    $sql .= " AND dd.maDon = ?";
    $params[] = intval($maDonTim);
    $types .= 'i';
}

if (!empty($maTourTim)) {
    $sql .= " AND dd.maTour = ?";
    $params[] = intval($maTourTim);
    $types .= 'i';
}

if (!empty($trangThai)) {
    $sql .= " AND dd.trangThaiTT = ?";
    $params[] = $trangThai;
    $types .= 's';
}

$sql .= " ORDER BY dd.thoiGianDat DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$donDats = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đơn đặt tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php include "../../includes/sideBar-NPP.php"; ?>

            <div class="col-md-9 col-lg-10 p-4" style="margin-left: 336px;">

                <h3 class="mb-4 text-title">Danh sách đơn đặt tour</h3>
                <hr>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <form action="quanLyDonDat.php" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label"><strong>Tìm kiếm</strong></label>
                                <input type="text" name="timKiem" class="form-control"
                                    placeholder="Tên khách hàng hoặc tour..."
                                    value="<?= htmlspecialchars($timKiem) ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label"><strong>ID Đơn</strong></label>
                                <input type="number" name="maDon" class="form-control"
                                    placeholder="Nhập ID đơn"
                                    value="<?= htmlspecialchars($maDonTim) ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label"><strong>ID Tour</strong></label>
                                <input type="number" name="maTour" class="form-control"
                                    placeholder="Nhập ID tour"
                                    value="<?= htmlspecialchars($maTourTim) ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label"><strong>Trạng thái</strong></label>
                                <select name="trangThai" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="Chờ thanh toán" <?= $trangThai === 'Chờ thanh toán' ? 'selected' : '' ?>>Chờ thanh toán</option>
                                    <option value="Đã thanh toán"  <?= $trangThai === 'Đã thanh toán'  ? 'selected' : '' ?>>Đã thanh toán</option>
                                    <option value="Đã hủy"         <?= $trangThai === 'Đã hủy'         ? 'selected' : '' ?>>Đã hủy</option>
                                    <option value="Hết hạn"        <?= $trangThai === 'Hết hạn'        ? 'selected' : '' ?>>Hết hạn</option>
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Tìm</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABLE -->
                <div class="content-box">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Đơn</th>
                                <th>ID Tour</th>
                                <th>Khách hàng</th>
                                <th>Tên tour</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Phương thức</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($don = $donDats->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $don['maDon'] ?></td>
                                    <td><?= $don['maTour'] ?></td>
                                    <td><?= htmlspecialchars($don['tenKhach']) ?></td>
                                    <td><?= htmlspecialchars($don['tenTour']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($don['thoiGianDat'])) ?></td>
                                    <td><?= number_format($don['tongTien'], 0, ',', '.') ?>đ</td>
                                    <td><?= $don['phuongThucTT'] ?? '-' ?></td>
                                    <td>
                                        <?php
                                        $badge = match($don['trangThaiTT']) {
                                            'Chờ thanh toán' => 'bg-warning text-dark',
                                            'Đã thanh toán'  => 'bg-success',
                                            'Đã hủy'         => 'bg-danger',
                                            'Hết hạn'        => 'bg-secondary',
                                            default          => 'bg-secondary'
                                        };
                                        ?>
                                        <span class="badge <?= $badge ?>"><?= $don['trangThaiTT'] ?></span>
                                    </td>
                                    <td>
                                        <a href="chiTietDonDat.php?maDon=<?= $don['maDon'] ?>"
                                            class="btn btn-info btn-sm">Xem</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if ($donDats->num_rows === 0): ?>
                                <tr>
                                    <td colspan="9" class="text-center">Không có đơn đặt nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>