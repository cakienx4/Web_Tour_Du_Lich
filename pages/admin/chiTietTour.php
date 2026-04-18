<?php
session_start();
require_once '../../config/database.php';

// Check quyền
if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

// Lấy maTour
$maTour = $_GET['maTour'] ?? null;

if (!$maTour) {
    header('Location: quanLyTour.php');
    exit();
}

// Lấy thông tin tour
$sql = "
SELECT t.*, u.hoTen, d.tenDiemDen
FROM tour t
JOIN user u ON t.maND = u.maND
JOIN tour_diemden td ON t.maTour = td.maTour
JOIN diemden d ON td.maDiemDen = d.maDiemDen
WHERE t.maTour = ?
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $maTour);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: quanLyTour.php');
    exit();
}

// Lấy ảnh
$stmtImg = $mysqli->prepare("
    SELECT duongDan FROM tour_anh WHERE maTour = ?
");
$stmtImg->bind_param("i", $maTour);
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
                <h3 class="mb-4 text-title">Chi tiết tour</h3>

                <div class="content-box-chiTiet">

                    <div class="title-box-chiTiet mb-3">
                        <!-- TÊN TOUR -->
                        <h4><?= htmlspecialchars($tour['tenTour']) ?></h4>
                        <a class="btn btn-primary" href="quanLyDonDat.php?maTour=<?= $tour['maTour'] ?>">
                            Danh sách đơn đặt
                        </a>
                    </div>

                    <hr>
                    <!-- Mã tour -->
                    <p><strong>Mã tour:</strong> <?= $tour['maTour'] ?></p>

                    <!-- NHÀ PHÂN PHỐI -->
                    <p><strong>Nhà phân phối:</strong> <?= htmlspecialchars($tour['hoTen']) ?></p>

                    <!-- NGÀY KHỞI HÀNH -->
                    <p><strong>Ngày khởi hành:</strong>
                        <?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?>
                    </p>

                    <!-- ĐIỂM ĐẾN -->
                    <p><strong>Điểm đến:</strong>
                        <?= htmlspecialchars($tour['tenDiemDen']) ?>
                    </p>

                    <!-- GIÁ -->
                    <p><strong>Giá:</strong>
                        <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ
                    </p>

                    <!-- SỐ CHỖ TRỐNG -->
                    <p><strong>Số chỗ trống:</strong>
                        <?= $tour['soChoTrong'] ?>
                    </p>

                    <!-- TRẠNG THÁI -->
                    <p>
                        <strong>Trạng thái:</strong>
                        <?php if ($tour['trangThai'] === 'Đang bán'): ?>
                            <span class="badge bg-success">Đang bán</span>
                        <?php elseif ($tour['trangThai'] === 'Tạm dừng'): ?>
                            <span class="badge bg-danger">Tạm dừng</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">
                                <?= $tour['trangThai'] ?>
                            </span>
                        <?php endif; ?>
                    </p>

                    <hr>

                    <!-- MÔ TẢ -->
                    <h5>Mô tả tour</h5>
                    <p>
                        <?= nl2br(htmlspecialchars($tour['moTa'])) ?>
                    </p>

                    <!-- LỊCH TRÌNH -->
                    <h5 class="mt-4">Lịch trình</h5>
                    <p>
                        <?= nl2br(htmlspecialchars($tour['lichTrinh'])) ?>
                    </p>

                    <!-- HÌNH ẢNH -->
                    <h5 class="mt-4">Hình ảnh</h5>
                    <div class="row">
                        <?php while ($img = $images->fetch_assoc()): ?>
                            <div class="col-md-4 mb-3">
                                <img src="../../<?= htmlspecialchars($img['duongDan']) ?>" class="img-fluid rounded">
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <hr>

                    <!-- ACTION -->
                    <div class="d-flex justify-content-between mb-3">

                        <a href="quanLyTours.php" class="btn btn-secondary">← Quay lại</a>
                        
                        <?php if ($tour['trangThai'] === 'Chờ duyệt'): ?>
                        <div>
                            <a href="../../actions/tour/approveTour.php?id=<?= $tour['maTour'] ?>"
                                class="btn btn-success" onclick="return confirm('Duyệt tour này?')">
                                Duyệt
                            </a>
                            <a href="../../actions/tour/rejectTour.php?id=<?= $tour['maTour'] ?>" class="btn btn-danger"
                                onclick="return confirm('Từ chối tour này?')">
                                Từ chối
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>

            </div>

        </div>
    </div>

</body>

</html>