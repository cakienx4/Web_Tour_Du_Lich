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
    SELECT t.*, td.maDiemDen
    FROM tour t
    LEFT JOIN tour_diemden td ON t.maTour = td.maTour
    WHERE t.maTour = ? AND t.maND = ? AND t.trangThai != 'Chờ duyệt'
");
$stmt->bind_param('ii', $maTour, $maND);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: quanLyTours.php');
    exit();
}

// Ảnh hiện tại
$stmtAnh = $mysqli->prepare("SELECT maAnh, duongDan, laManhChinh FROM tour_anh WHERE maTour = ?");
$stmtAnh->bind_param('i', $maTour);
$stmtAnh->execute();
$dsAnh = $stmtAnh->get_result()->fetch_all(MYSQLI_ASSOC);

$anhChinh = array_filter($dsAnh, fn($a) => $a['laManhChinh'] == 1);
$anhChinh = array_values($anhChinh)[0] ?? null;
$anhPhu   = array_filter($dsAnh, fn($a) => $a['laManhChinh'] == 0);

$dsDiemDen = $mysqli->query("SELECT maDiemDen, tenDiemDen FROM diemden ORDER BY tenDiemDen ASC");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php include "../../includes/sideBar-NPP.php"; ?>

            <div class="col-md-9 col-lg-10 p-4" style="margin-left: 336px;">

                <h3 class="mb-4 text-title">Chỉnh sửa tour</h3>
                <hr>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        echo match ($_GET['error']) {
                            'missing' => 'Vui lòng điền đầy đủ thông tin bắt buộc.',
                            'date'    => 'Ngày khởi hành phải sau ngày hôm nay.',
                            'upload'  => 'Có lỗi khi tải ảnh lên, vui lòng thử lại.',
                            'db'      => 'Có lỗi khi lưu dữ liệu, vui lòng thử lại.',
                            default   => 'Có lỗi xảy ra, vui lòng thử lại.',
                        };
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="content-box">
                    <form action="../../actions/tour/fixTour.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="maTour" value="<?= $tour['maTour'] ?>">

                        <div class="row">

                            <!-- TÊN TOUR -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>Tên tour <span class="text-danger">*</span></strong></label>
                                <input type="text" name="tenTour" class="form-control"
                                    value="<?= htmlspecialchars($tour['tenTour']) ?>" required>
                            </div>

                            <!-- GIÁ -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"><strong>Giá (VNĐ) <span class="text-danger">*</span></strong></label>
                                <input type="number" name="giaTour" class="form-control"
                                    value="<?= $tour['giaTour'] ?>" min="0" required>
                            </div>

                            <!-- SỐ LƯỢNG -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"><strong>Số lượng khách <span class="text-danger">*</span></strong></label>
                                <input type="number" name="tongSoCho" class="form-control"
                                    value="<?= $tour['tongSoCho'] ?>" min="1" required>
                            </div>

                            <!-- NGÀY KHỞI HÀNH -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"><strong>Ngày khởi hành <span class="text-danger">*</span></strong></label>
                                <input type="date" name="ngayKhoiHanh" class="form-control"
                                    value="<?= $tour['ngayKhoiHanh'] ?>" required>
                            </div>

                            <!-- SỐ NGÀY -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label"><strong>Số ngày <span class="text-danger">*</span></strong></label>
                                <input type="number" name="soNgay" class="form-control"
                                    value="<?= $tour['soNgay'] ?>" min="1" required>
                            </div>

                            <!-- ĐIỂM XUẤT PHÁT -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label"><strong>Điểm xuất phát <span class="text-danger">*</span></strong></label>
                                <input type="text" name="diemXuatPhat" class="form-control"
                                    value="<?= htmlspecialchars($tour['diemXuatPhat']) ?>" required>
                            </div>

                            <!-- ĐIỂM ĐẾN -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"><strong>Điểm đến <span class="text-danger">*</span></strong></label>
                                <select name="maDiemDen" class="form-select" required>
                                    <option value="">-- Chọn điểm đến --</option>
                                    <?php while ($dd = $dsDiemDen->fetch_assoc()): ?>
                                        <option value="<?= $dd['maDiemDen'] ?>"
                                            <?= $dd['maDiemDen'] == $tour['maDiemDen'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($dd['tenDiemDen']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- ẢNH CHÍNH HIỆN TẠI -->
                            <?php if ($anhChinh): ?>
                                <div class="col-md-12 mb-2">
                                    <label class="form-label"><strong>Ảnh chính hiện tại</strong></label><br>
                                    <img src="../../<?= htmlspecialchars($anhChinh['duongDan']) ?>"
                                        style="height: 150px; object-fit: cover; border-radius: 6px;">
                                </div>
                            <?php endif; ?>

                            <!-- ẢNH CHÍNH MỚI -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>Đổi ảnh chính</strong></label>
                                <input type="file" name="anhChinh" class="form-control" accept="image/*">
                                <div class="form-text">Để trống nếu không muốn thay đổi.</div>
                            </div>

                            <!-- ẢNH PHỤ MỚI -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>Thêm ảnh phụ</strong></label>
                                <input type="file" name="anhPhu[]" class="form-control" accept="image/*" multiple>
                                <div class="form-text">Ảnh phụ cũ sẽ được giữ nguyên, ảnh mới sẽ được thêm vào.</div>
                            </div>

                            <!-- MÔ TẢ -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label"><strong>Mô tả <span class="text-danger">*</span></strong></label>
                                <textarea name="moTa" class="form-control" rows="4" required><?= htmlspecialchars($tour['moTa']) ?></textarea>
                            </div>

                            <!-- LỊCH TRÌNH -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label"><strong>Lịch trình</strong></label>
                                <textarea name="lichTrinh" class="form-control" rows="4"><?= htmlspecialchars($tour['lichTrinh'] ?? '') ?></textarea>
                            </div>

                        </div>

                        <div class="d-flex justify-content-between action-group">
                            <a href="chiTietTour.php?maTour=<?= $maTour ?>" class="btn btn-secondary">← Hủy</a>
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>