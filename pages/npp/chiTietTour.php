<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maND   = intval($_SESSION['maND']);
$maTour = intval($_GET['maTour'] ?? 0);

if (!$maTour) {
    header('Location: quanLyTours.php');
    exit();
}

$stmt = $mysqli->prepare("
    SELECT t.*, u.hoTen, GROUP_CONCAT(d.tenDiemDen SEPARATOR ', ') AS tenDiemDen
    FROM tour t
    JOIN user u ON t.maND = u.maND
    JOIN tour_diemden td ON t.maTour = td.maTour
    JOIN diemden d ON td.maDiemDen = d.maDiemDen
    WHERE t.maTour = ? AND t.maND = ?
    GROUP BY t.maTour
");
$stmt->bind_param('ii', $maTour, $maND);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: quanLyTours.php');
    exit();
}

$stmtImg = $mysqli->prepare("SELECT duongDan FROM tour_anh WHERE maTour = ?");
$stmtImg->bind_param('i', $maTour);
$stmtImg->execute();
$images = $stmtImg->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php include "../../includes/sideBar-NPP.php"; ?>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <h3 class="mb-4 text-title">Chi tiết tour</h3>

                <div class="content-box-chiTiet">

                    <div class="title-box-chiTiet mb-3">
                        <h4><?= htmlspecialchars($tour['tenTour']) ?></h4>
                        <a class="btn btn-primary" href="quanLyDonDat.php?maTour=<?= $tour['maTour'] ?>">
                            Danh sách đơn đặt
                        </a>
                    </div>

                    <hr>

                    <p><strong>Mã tour:</strong> <?= $tour['maTour'] ?></p>
                    <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?></p>
                    <p><strong>Số ngày:</strong> <?= $tour['soNgay'] ?> ngày</p>
                    <p><strong>Điểm xuất phát:</strong> <?= htmlspecialchars($tour['diemXuatPhat']) ?></p>
                    <p><strong>Điểm đến:</strong> <?= htmlspecialchars($tour['tenDiemDen']) ?></p>
                    <p><strong>Giá:</strong> <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ</p>
                    <p><strong>Số chỗ còn:</strong> <?= $tour['soChoTrong'] ?>/<?= $tour['tongSoCho'] ?></p>
                    <p>
                        <strong>Trạng thái:</strong>
                        <?php if ($tour['trangThai'] === 'Đang bán'): ?>
                            <span class="badge bg-success">Đang bán</span>
                        <?php elseif ($tour['trangThai'] === 'Tạm dừng'): ?>
                            <span class="badge bg-secondary">Tạm dừng</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark"><?= $tour['trangThai'] ?></span>
                        <?php endif; ?>
                    </p>

                    <hr>

                    <h5>Mô tả tour</h5>
                    <p><?= nl2br(htmlspecialchars($tour['moTa'])) ?></p>

                    <h5 class="mt-4">Lịch trình</h5>
                    <p><?= nl2br(htmlspecialchars($tour['lichTrinh'] ?? 'Chưa cập nhật')) ?></p>

                    <h5 class="mt-4">Hình ảnh</h5>
                    <div class="row">
                        <?php while ($img = $images->fetch_assoc()): ?>
                            <div class="col-md-4 mb-3">
                                <img src="../../<?= htmlspecialchars($img['duongDan']) ?>" class="img-fluid rounded">
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <a href="quanLyTours.php" class="btn btn-secondary">← Quay lại</a>

                        <?php if ($tour['trangThai'] !== 'Chờ duyệt'): ?>
                            <a href="suaTour.php?maTour=<?= $tour['maTour'] ?>" class="btn btn-warning">Sửa tour</a>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</body>

</html>