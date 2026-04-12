<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Khách hàng') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maTour = $_GET['id'] ?? null;
if (!$maTour) {
    header('Location: tour.php');
    exit();
}

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

$stmtAnh = $mysqli->prepare("
    SELECT duongDan FROM tour_anh 
    WHERE maTour = ? AND laManhChinh = 1 
    LIMIT 1
");
$stmtAnh->bind_param("i", $maTour);
$stmtAnh->execute();
$anhChinh = $stmtAnh->get_result()->fetch_assoc();

$stmtUser = $mysqli->prepare("SELECT hoTen, soDienThoai FROM user WHERE maND = ?");
$stmtUser->bind_param("i", $_SESSION['maND']);
$stmtUser->execute();
$user = $stmtUser->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt Tour</title>
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
                    <li class="breadcrumb-item">
                        <a href="tour_ChiTiet.php?id=<?= $tour['maTour'] ?>" class="breadcrumb-link">
                            <?= htmlspecialchars($tour['tenTour']) ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Đặt tour</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if (!empty($_GET['error'])): ?>
        <div class="container mt-3">
            <?php if ($_GET['error'] === 'khong_du_cho'): ?>
                <div class="alert alert-danger">Không đủ số chỗ trống. Vui lòng giảm số người.</div>
            <?php elseif ($_GET['error'] === 'loi_he_thong'): ?>
                <div class="alert alert-danger">Lỗi hệ thống. Vui lòng thử lại.</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="container my-4">

        <!-- TOUR INFO -->
        <div class="box tour-summary">
            <img src="../../<?= htmlspecialchars($anhChinh['duongDan'] ?? '') ?>"
                alt="<?= htmlspecialchars($tour['tenTour']) ?>">
            <div class="tour-summary-content">
                <div class="tour-title"><?= htmlspecialchars($tour['tenTour']) ?></div>
                <p><strong>Thời gian:</strong> <?= $tour['soNgay'] ?> ngày <?= $tour['soNgay'] - 1 ?> đêm</p>
                <p><strong>Khởi hành:</strong> <?= htmlspecialchars($tour['diemXuatPhat']) ?></p>
                <p><strong>Số chỗ còn lại:</strong> <?= $tour['soChoTrong'] ?></p>
            </div>
        </div>

        <div class="row">

            <!-- FORM -->
            <div class="col-lg-8">
                <div class="box">
                    <h4 class="mb-3">Thông tin đặt tour</h4>

                    <form action="../../actions/donDat/booking.php" method="POST" id="formDatTour">
                        <input type="hidden" name="maTour" value="<?= $tour['maTour'] ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Ngày khởi hành</h5>
                                </label>
                                <input type="date" name="ngayDat" class="form-control"
                                    value="<?= $tour['ngayKhoiHanh'] ?>" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Số lượng người</h5>
                                </label>
                                <input type="number" name="soNguoi" id="soNguoi" class="form-control" min="1"
                                    max="<?= $tour['soChoTrong'] ?>" value="1" required>
                            </div>
                        </div>

                        <h4 class="mt-3">Thông tin liên hệ</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Họ và tên</h5>
                                </label>
                                <input type="text" name="hoTen" class="form-control"
                                    value="<?= htmlspecialchars($user['hoTen']) ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Số điện thoại</h5>
                                </label>
                                <input type="tel" name="soDienThoai" class="form-control"
                                    value="<?= htmlspecialchars($user['soDienThoai']) ?>" required>
                            </div>
                        </div>

                </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">
                <div class="box">
                    <h4>Đơn đặt</h4>
                    <hr>
                    <p><strong>Giá tour: </strong>
                        <span class="price"><?= number_format($tour['giaTour'], 0, ',', '.') ?>đ / người</span>
                    </p>
                    <p><strong>Số khách:</strong> <span id="hienThiSoNguoi">1</span></p>
                    <hr>
                    <h5>Tổng tiền: <span class="price" id="tongTien">
                            <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ
                        </span></h5>

                    <button type="submit" class="btn-book text-white mt-3">
                        Gửi yêu cầu đặt tour
                    </button>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const gia = <?= $tour['giaTour'] ?>;
        const inputSoNguoi = document.getElementById('soNguoi');
        const tongTienSpan = document.getElementById('tongTien');
        const hienThiSoNguoi = document.getElementById('hienThiSoNguoi');

        inputSoNguoi.addEventListener('input', function () {
            const soNguoi = parseInt(this.value) || 1;
            hienThiSoNguoi.textContent = soNguoi;
            tongTienSpan.textContent = (gia * soNguoi).toLocaleString('vi-VN') + 'đ';
        });
    </script>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>