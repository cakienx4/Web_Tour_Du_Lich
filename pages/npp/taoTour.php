<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

// Lấy danh sách điểm đến từ DB
$dsDiemDen = $mysqli->query("SELECT maDiemDen, tenDiemDen FROM diemden ORDER BY tenDiemDen ASC");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>
    <!-- SIDEBAR -->
    <?php include "../../includes/sideBar-NPP.php"; ?>

    <!-- CONTENT -->
    <div class="main-content p-4">

        <h3 class="mb-4 text-title">Tạo tour mới</h3>
        <hr>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php
                echo match ($_GET['error']) {
                    'missing'  => 'Vui lòng điền đầy đủ thông tin bắt buộc.',
                    'upload'   => 'Có lỗi khi tải ảnh lên, vui lòng thử lại.',
                    'db'       => 'Có lỗi khi lưu dữ liệu, vui lòng thử lại.',
                    'date'     => 'Ngày khởi hành phải sau ngày hôm nay.',
                    default    => 'Có lỗi xảy ra, vui lòng thử lại.',
                };
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="content-box">
            <form action="../../actions/tour/createTour.php" method="POST" enctype="multipart/form-data">

                <div class="row">

                    <!-- TÊN TOUR -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Tên tour <span class="text-danger">*</span></strong></label>
                        <input type="text" name="tenTour" class="form-control" required>
                    </div>

                    <!-- GIÁ -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><strong>Giá (VNĐ) <span class="text-danger">*</span></strong></label>
                        <input type="number" name="giaTour" class="form-control" min="0" required>
                    </div>

                    <!-- SỐ LƯỢNG -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><strong>Số lượng khách <span class="text-danger">*</span></strong></label>
                        <input type="number" name="tongSoCho" class="form-control" min="1" required>
                    </div>

                    <!-- NGÀY KHỞI HÀNH -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><strong>Ngày khởi hành <span class="text-danger">*</span></strong></label>
                        <input type="date" name="ngayKhoiHanh" class="form-control" required>
                    </div>

                    <!-- SỐ NGÀY -->
                    <div class="col-md-2 mb-3">
                        <label class="form-label"><strong>Số ngày <span class="text-danger">*</span></strong></label>
                        <input type="number" name="soNgay" class="form-control" min="1" placeholder="Ví dụ: 3" required>
                    </div>

                    <!-- ĐIỂM XUẤT PHÁT -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><strong>Điểm xuất phát <span class="text-danger">*</span></strong></label>
                        <input type="text" name="diemXuatPhat" class="form-control" placeholder="Ví dụ: Hồ Chí Minh" required>
                    </div>

                    <!-- ĐIỂM ĐẾN -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><strong>Điểm đến <span class="text-danger">*</span></strong></label>
                        <select name="maDiemDen" class="form-select" required>
                            <option value="">-- Chọn điểm đến --</option>
                            <?php while ($dd = $dsDiemDen->fetch_assoc()): ?>
                                <option value="<?= $dd['maDiemDen'] ?>">
                                    <?= htmlspecialchars($dd['tenDiemDen']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- ẢNH CHÍNH -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Ảnh chính <span class="text-danger">*</span></strong></label>
                        <input type="file" name="anhChinh" class="form-control" accept="image/*" required>
                        <div class="form-text">Ảnh đại diện hiển thị trên danh sách tour.</div>
                    </div>

                    <!-- ẢNH PHỤ -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Ảnh phụ</strong></label>
                        <input type="file" name="anhPhu[]" class="form-control" accept="image/*" multiple>
                        <div class="form-text">Có thể chọn nhiều ảnh.</div>
                    </div>

                    <!-- MÔ TẢ -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label"><strong>Mô tả <span class="text-danger">*</span></strong></label>
                        <textarea name="moTa" class="form-control" rows="4" required></textarea>
                    </div>

                    <!-- LỊCH TRÌNH -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label"><strong>Lịch trình</strong></label>
                        <textarea name="lichTrinh" class="form-control" rows="4" placeholder="Mô tả lịch trình chi tiết theo từng ngày..."></textarea>
                    </div>

                </div>

                <!-- ACTION -->
                <div class="d-flex justify-content-end action-group">
                    <a href="quanLyTours.php" class="btn btn-secondary me-2">Hủy</a>
                    <button type="submit" class="btn btn-success">Tạo tour</button>
                </div>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>