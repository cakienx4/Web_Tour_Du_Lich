<?php
session_start();
require_once '../../config/database.php';

// Lấy maTour từ URL
$maTour = $_GET['id'] ?? null;

if (!$maTour) {
    header('Location: tour.php');
    exit();
}

// Lấy thông tin tour
$stmt = $mysqli->prepare("
    SELECT t.*, u.hoTen AS tenNPP
    FROM tour t
    JOIN user u ON t.maND = u.maND
    WHERE t.maTour = ? AND t.trangThai = 'Đang bán'
");
$stmt->bind_param("i", $maTour);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: tour.php');
    exit();
}

// Lấy điểm đến của tour
$stmtDD = $mysqli->prepare("
    SELECT d.tenDiemDen, d.vungMien
    FROM diemden d
    JOIN tour_diemden td ON d.maDiemDen = td.maDiemDen
    WHERE td.maTour = ?
");
$stmtDD->bind_param("i", $maTour);
$stmtDD->execute();
$diemDens = $stmtDD->get_result();
$tenDiemDen = [];
while ($dd = $diemDens->fetch_assoc()) {
    $tenDiemDen[] = $dd['tenDiemDen'];
}
// Lấy ảnh chính
$stmtAnh = $mysqli->prepare("
    SELECT duongDan FROM tour_anh 
    WHERE maTour = ? AND laManhChinh = 1 
    LIMIT 1
");
$stmtAnh->bind_param("i", $maTour);
$stmtAnh->execute();
$anhChinh = $stmtAnh->get_result()->fetch_assoc();

// Lấy ảnh gallery
$stmtGallery = $mysqli->prepare("
    SELECT duongDan FROM tour_anh 
    WHERE maTour = ? AND laManhChinh = 0
");
$stmtGallery->bind_param("i", $maTour);
$stmtGallery->execute();
$anhGallery = $stmtGallery->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <title>Chi tiết Tour</title>
    <link rel="stylesheet" href="../../assets/css/khachHang.css">

</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <!-- ------------------------------------- BREADCRUMB ------------------------------------- -->
    <div class="breadcrumb-box">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb tour-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="trangChu.php" class="breadcrumb-link">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="tour.php" class="breadcrumb-link">Danh sách tour</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?= htmlspecialchars($tour['tenTour']) ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <?php if (!empty($_GET['baocao'])): ?>
        <div class="container mt-3">
            <div class="alert alert-success">Báo cáo của bạn đã được gửi thành công!</div>
        </div>
    <?php elseif (!empty($_GET['error'])): ?>
        <div class="container mt-3">
            <div class="alert alert-danger">
                <?= $_GET['error'] === 'thieu_thong_tin' ? 'Vui lòng điền đầy đủ thông tin.' : 'Lỗi hệ thống. Vui lòng thử lại.' ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="container my-4">
        <!-- ------------------------------------- TITLE ------------------------------------- -->

        <h1 class="tour-title">
            <?= htmlspecialchars($tour['tenTour']) ?>
        </h1>

        <div class="row mt-4">

            <!-- ------------------------------------- NỬA TRÁI ------------------------------------- -->
            <!-- ------------------------------------- NỬA TRÁI ------------------------------------- -->

            <div class="col-lg-7">

                <!-- ------------------------------------- IMAGE ------------------------------------- -->

                <div class="main-image">
                    <?php if ($anhChinh): ?>
                        <img src="../../<?= htmlspecialchars($anhChinh['duongDan']) ?>"
                            alt="<?= htmlspecialchars($tour['tenTour']) ?>">
                    <?php else: ?>
                        <img src="../../assets/img/placeholder.jpg" alt="Chưa có ảnh">
                    <?php endif; ?>
                </div>

                <div class="image-gallery">
                    <?php if ($anhGallery->num_rows > 0): ?>
                        <?php while ($anh = $anhGallery->fetch_assoc()): ?>
                            <img src="../../<?= htmlspecialchars($anh['duongDan']) ?>"
                                alt="<?= htmlspecialchars($tour['tenTour']) ?>">
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Chưa có ảnh gallery.</p>
                    <?php endif; ?>
                </div>

                <!-- ------------------------------------- MÔ TẢ TOUR ------------------------------------- -->

                <div class="box tour-section">
                    <h1>Giới thiệu tour</h1>
                    <p>
                        <?= nl2br(htmlspecialchars($tour['moTa'])) ?>
                    </p>
                </div>

                <!-- ------------------------------------- LỊCH TRÌNH TOUR ------------------------------------- -->

                <div class="box tour-section">
                    <h1>Lịch trình tour</h1>
                    <p>
                        <?= nl2br(htmlspecialchars($tour['lichTrinh'])) ?>
                    </p>
                </div>
            </div>

            <!-- ------------------------------------- NỬA PHẢI ------------------------------------- -->
            <!-- ------------------------------------- NỬA PHẢI ------------------------------------- -->

            <div class="col-lg-5">

                <!-- ------------------------------------- BẢNG ĐẶT TOUR ------------------------------------- -->

                <div class="box">
                    <div class="tour-info">
                        <p><strong>Thời gian:</strong>
                            <?= $tour['soNgay'] ?> ngày
                            <?= $tour['soNgay'] - 1 ?> đêm
                        </p>
                        <p><strong>Khởi hành:</strong>
                            <?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?>
                        </p>
                        <p><strong>Điểm đến:</strong>
                            <?= htmlspecialchars(implode(', ', $tenDiemDen)) ?>
                        </p>
                        <p><strong>Nhà tổ chức:</strong>
                            <?= htmlspecialchars($tour['tenNPP']) ?>
                        </p>
                        <p><strong>Số chỗ còn lại:</strong>
                            <?= $tour['soChoTrong'] ?>
                        </p>
                    </div>
                    <div class="price-box">
                        <span class="price">
                            <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ / người
                        </span>
                    </div>
                    <?php if (isset($_SESSION['vaiTro']) && $_SESSION['vaiTro'] === 'Khách hàng'): ?>
                        <div class="d-grid gap-2">
                            <a href="datTour.php?id=<?= $tour['maTour'] ?>" class="btn btn-danger fw-bold">Đặt tour ngay</a>
                            <button type="button" class="btn btn-warning fw-bold" data-bs-toggle="modal"
                                data-bs-target="#popupBaoCao">
                                Báo cáo vi phạm
                            </button>
                        </div>
                    <?php else: ?>
                        <a href="../auth/dangNhap.php" class="btn-book">Đăng nhập để đặt tour</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <div class="modal fade" id="popupBaoCao" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0">
                    <h4 class="modal-title">Báo cáo vi phạm tour</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Nếu bạn phát hiện tour có dấu hiệu sai lệch thông tin hoặc lừa đảo, vui lòng gửi báo cáo để
                        chúng tôi kiểm tra và xử lý kịp thời.
                    </p>
                    <p class="text-muted">Tour: <strong>
                            <?= htmlspecialchars($tour['tenTour']) ?>
                        </strong></p>
                    <form action="../../actions/baoCao/createReport.php" method="POST">
                        <input type="hidden" name="maTour" value="<?= $tour['maTour'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Lý do báo cáo</label>
                            <select name="lyDo" class="form-select" required>
                                <option value="">-- Chọn lý do --</option>
                                <option value="Thông tin không chính xác">Thông tin không chính xác</option>
                                <option value="Giá không minh bạch">Giá không minh bạch</option>
                                <option value="Dấu hiệu lừa đảo">Dấu hiệu lừa đảo</option>
                                <option value="Dịch vụ không đúng cam kết">Dịch vụ không đúng cam kết</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea name="noiDung" class="form-control" rows="4" placeholder="Nhập mô tả chi tiết..."
                                required></textarea>
                        </div>

                        <button class="btn btn-danger w-100">Gửi báo cáo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>