<?php
session_start();
require_once '../../config/database.php';

$stmt = $mysqli->prepare("
    SELECT dd.*, t.tenTour, t.soNgay, t.ngayKhoiHanh,
           (SELECT duongDan FROM tour_anh WHERE maTour = t.maTour AND laManhChinh = 1 LIMIT 1) AS anhTour
    FROM dondat dd
    JOIN tour t ON dd.maTour = t.maTour
    WHERE dd.maND = ?
    ORDER BY dd.ngayKhoiHanh DESC
");
$stmt->bind_param("i", $_SESSION['maND']);
$stmt->execute();
$donDatList = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch sử đặt tour</title>
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
                    <li class="breadcrumb-item active">Lịch sử đặt tour</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container my-5 py-4">
        <div class="page-title">Lịch sử đơn đặt của tôi</div>

        <?php if ($donDatList->num_rows === 0): ?>
            <div class="box text-center">
                <p>Bạn chưa có đơn đặt tour nào.</p>
                <a href="tour.php" class="btn-book text-white">Khám phá tour ngay</a>
            </div>
        <?php endif; ?>

        <?php while ($don = $donDatList->fetch_assoc()): ?>
            <div class="box">
                <div class="row align-items-center">

                    <div class="col-md-2">
                        <img src="../../<?= htmlspecialchars($don['anhTour'] ?? '') ?>"
                            alt="<?= htmlspecialchars($don['tenTour']) ?>" style="width:100%; border-radius:8px;">
                    </div>

                    <div class="col-md-7">
                        <div class="tour-title"><?= htmlspecialchars($don['tenTour']) ?></div>
                        <div class="tour-info">
                            <p><strong>Mã đơn:</strong> #<?= $don['maDon'] ?></p>
                            <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($don['ngayKhoiHanh'])) ?></p>
                            <p><strong>Thời gian:</strong> <?= $don['soNgay'] ?> ngày <?= $don['soNgay'] - 1 ?> đêm</p>
                            <p><strong>Số người:</strong> <?= $don['soNguoi'] ?></p>
                            <p><strong>Tổng tiền:</strong>
                                <span class="price"><?= number_format($don['tongTien'], 0, ',', '.') ?>đ</span>
                            </p>
                            <p><strong>Trạng thái:</strong>
                                <?php if ($don['trangThaiTT'] === 'daThanhToan'): ?>
                                    <span class="status status-upcoming">Đã thanh toán</span>
                                <?php elseif ($don['trangThaiTT'] === 'daHuy'): ?>
                                    <span class="status status-finished">Đã hủy</span>
                                <?php else: ?>
                                    <span class="status" style="background:#fff3cd; color:#856404;">Chờ thanh toán</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-3 text-end">
                        <?php if ($don['trangThaiTT'] === 'choPhanHoi'): ?>
                            <a href="thanhToan.php?maDon=<?= $don['maDon'] ?>" class="btn btn-danger text-white mb-2 w-100">
                                Thanh toán
                            </a>
                            <br>
                            <a href="../../actions/donDat/cancelBooking.php?maDon=<?= $don['maDon'] ?>"
                                class="btn btn-outline-danger cancel-btn w-100">
                                Hủy đơn
                            </a>
                        <?php elseif ($don['trangThaiTT'] === 'daThanhToan'): ?>
                            <a href="../../actions/donDat/cancelBooking.php?maDon=<?= $don['maDon'] ?>"
                                class="btn btn-outline-danger cancel-btn w-100">
                                Hủy đơn
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>