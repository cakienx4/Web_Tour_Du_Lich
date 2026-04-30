<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maDon = intval($_GET['maDon'] ?? 0);

if (!$maDon) {
    header('Location: quanLyDonDat.php');
    exit();
}

$stmt = $mysqli->prepare("
    SELECT dd.maDon, dd.thoiGianDat, dd.soNguoi, dd.tongTien,
           dd.phuongThucTT, dd.thoiGianThanhToan, dd.trangThaiTT,
           u.hoTen AS tenKhach, u.email, u.soDienThoai,
           t.maTour, t.tenTour, t.ngayKhoiHanh,
           GROUP_CONCAT(d.tenDiemDen SEPARATOR ', ') AS tenDiemDen
    FROM dondat dd
    JOIN user u ON dd.maND = u.maND
    JOIN tour t ON dd.maTour = t.maTour
    LEFT JOIN tour_diemden td ON t.maTour = td.maTour
    LEFT JOIN diemden d ON td.maDiemDen = d.maDiemDen
    WHERE dd.maDon = ?
    GROUP BY dd.maDon
");
$stmt->bind_param('i', $maDon);
$stmt->execute();
$don = $stmt->get_result()->fetch_assoc();

if (!$don) {
    header('Location: quanLyDonDat.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn đặt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <?php include "../../includes/sideBar-admin.php"; ?>

    <div class="main-content p-4">

        <h3 class="mb-4 text-title">Chi tiết đơn đặt tour</h3>

        <div class="content-box-chiTiet">

            <!-- THÔNG TIN ĐƠN -->
            <h4 class="mb-3">Thông tin đơn đặt</h4>
            <p><strong>Mã đơn:</strong> <?= $don['maDon'] ?></p>
            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($don['thoiGianDat'])) ?></p>
            <p><strong>Số người:</strong> <?= $don['soNguoi'] ?></p>
            <p><strong>Tổng tiền:</strong> <?= number_format($don['tongTien'], 0, ',', '.') ?>đ</p>

            <hr>

            <!-- KHÁCH HÀNG -->
            <h4 class="mb-3">Thông tin khách hàng</h4>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($don['tenKhach']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($don['email']) ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($don['soDienThoai']) ?></p>

            <hr>

            <!-- TOUR -->
            <h4 class="mb-3">Thông tin tour</h4>
            <p><strong>Mã tour:</strong> <?= $don['maTour'] ?></p>
            <p><strong>Tên tour:</strong> <?= htmlspecialchars($don['tenTour']) ?></p>
            <p><strong>Điểm đến:</strong> <?= htmlspecialchars($don['tenDiemDen'] ?? '—') ?></p>
            <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($don['ngayKhoiHanh'])) ?></p>

            <hr>

            <!-- THANH TOÁN -->
            <h4 class="mb-3">Thanh toán</h4>
            <p><strong>Phương thức:</strong> <?= $don['phuongThucTT'] ?? '—' ?></p>
            <p><strong>Thời gian thanh toán:</strong>
                <?= $don['thoiGianThanhToan'] ? date('d/m/Y H:i', strtotime($don['thoiGianThanhToan'])) : '—' ?>
            </p>
            <p>
                <strong>Trạng thái:</strong>
                <?php
                $badge = match ($don['trangThaiTT']) {
                    'Chờ thanh toán' => 'bg-warning text-dark',
                    'Đã thanh toán'  => 'bg-success',
                    'Đã hủy'         => 'bg-danger',
                    'Hết hạn'        => 'bg-secondary',
                    default          => 'bg-secondary'
                };
                ?>
                <span class="badge <?= $badge ?>"><?= $don['trangThaiTT'] ?></span>
            </p>

            <hr>

            <div class="d-flex justify-content-between action-group mb-3">
                <a href="quanLyDonDat.php" class="btn btn-secondary">← Quay lại</a>
            </div>

        </div>

    </div>
</body>

</html>