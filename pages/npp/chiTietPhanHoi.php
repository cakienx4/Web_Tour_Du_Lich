<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maND      = intval($_SESSION['maND']);
$maPhanHoi = intval($_GET['maPhanHoi'] ?? 0);

if (!$maPhanHoi) {
    header('Location: nhanPhanHoi.php');
    exit();
}

$stmt = $mysqli->prepare("
    SELECT ph.maPhanHoi, ph.noiDung, ph.ngayGui, ph.trangThai,
           bc.maBaoCao, bc.noiDung AS noiDungBaoCao, bc.ngayGui AS ngayGuiBaoCao,
           t.maTour, t.tenTour
    FROM phanhoi ph
    JOIN baocao bc ON ph.maBaoCao = bc.maBaoCao
    JOIN tour t ON bc.maTour = t.maTour
    WHERE ph.maPhanHoi = ? AND t.maND = ?
");
$stmt->bind_param('ii', $maPhanHoi, $maND);
$stmt->execute();
$ph = $stmt->get_result()->fetch_assoc();

if (!$ph) {
    header('Location: nhanPhanHoi.php');
    exit();
}

// Đánh dấu đã xem nếu chưa xem
if ($ph['trangThai'] === 'chuaXem') {
    $stmt = $mysqli->prepare("UPDATE phanhoi SET trangThai = 'daXem' WHERE maPhanHoi = ?");
    $stmt->bind_param('i', $maPhanHoi);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết phản hồi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>
    <?php include "../../includes/sideBar-NPP.php"; ?>

    <div class="main-content p-4">

        <h3 class="mb-4 text-title">Chi tiết phản hồi</h3>

        <div class="content-box-chiTiet">

            <h4 class="mb-3">Tour liên quan</h4>
            <p><strong>Mã tour:</strong> <?= $ph['maTour'] ?></p>
            <p><strong>Tên tour:</strong>
                <a href="chiTietTour.php?maTour=<?= $ph['maTour'] ?>">
                    <?= htmlspecialchars($ph['tenTour']) ?>
                </a>
            </p>

            <hr>

            <h4 class="mb-3">Báo cáo vi phạm</h4>
            <p><strong>Mã báo cáo:</strong> <?= $ph['maBaoCao'] ?></p>
            <p><strong>Ngày gửi báo cáo:</strong> <?= date('d/m/Y', strtotime($ph['ngayGuiBaoCao'])) ?></p>
            <p><strong>Nội dung báo cáo:</strong></p>
            <div class="p-3 bg-light rounded mb-3">
                <?= nl2br(htmlspecialchars($ph['noiDungBaoCao'])) ?>
            </div>

            <hr>

            <h4 class="mb-3">Phản hồi từ Quản trị viên</h4>
            <p><strong>Ngày phản hồi:</strong> <?= date('d/m/Y', strtotime($ph['ngayGui'])) ?></p>
            <p><strong>Nội dung:</strong></p>
            <div class="p-3 bg-light rounded mb-3">
                <?= nl2br(htmlspecialchars($ph['noiDung'])) ?>
            </div>

            <hr>

            <div class="d-flex justify-content-between mb-3">
                <a href="nhanPhanHoi.php" class="btn btn-secondary">← Quay lại</a>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>