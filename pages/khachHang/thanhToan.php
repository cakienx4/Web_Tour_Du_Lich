<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Khách hàng') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maDon = $_GET['maDon'] ?? null;
if (!$maDon) {
    header('Location: tour.php');
    exit();
}

$stmt = $mysqli->prepare("
    SELECT dd.*, t.tenTour, t.ngayKhoiHanh, u.hoTen, u.soDienThoai,
           TIMESTAMPDIFF(SECOND, dd.thoiGianDat, NOW()) AS giayDaQua
    FROM dondat dd
    JOIN tour t ON dd.maTour = t.maTour
    JOIN user u ON dd.maND = u.maND
    WHERE dd.maDon = ? AND dd.maND = ?
");
$stmt->bind_param("ii", $maDon, $_SESSION['maND']);
$stmt->execute();
$don = $stmt->get_result()->fetch_assoc();

if (!$don) {
    header('Location: tour.php');
    exit();
}

// Giới hạn 5 phút = 300 giây, tính bằng MySQL để tránh lệch múi giờ
$gioiHanGiay = 300;
$giayConLai = $gioiHanGiay - intval($don['giayDaQua']);

if ($don['trangThaiTT'] === 'Hết hạn' || $don['trangThaiTT'] === 'Đã hủy') {
    header('Location: tour.php?error=het_han');
    exit();
}

if ($giayConLai <= 0) {
    $stmtXoa = $mysqli->prepare("
        UPDATE dondat SET trangThaiTT = 'Hết hạn' WHERE maDon = ? AND trangThaiTT = 'Chờ thanh toán'
    ");
    $stmtXoa->bind_param("i", $maDon);
    $stmtXoa->execute();

    // Hoàn chỗ trống
    $stmtHoan = $mysqli->prepare("
        UPDATE tour t
        JOIN dondat dd ON t.maTour = dd.maTour
        SET t.soChoTrong = t.soChoTrong + dd.soNguoi
        WHERE dd.maDon = ?
    ");
    $stmtHoan->bind_param("i", $maDon);
    $stmtHoan->execute();

    header('Location: tour.php?error=het_han');
    exit();
}

$thanhCong = false;
$anhQR = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['xacNhanThanhToan'])) {
    $phuongThuc = $_POST['payment_method'] ?? '';

    $stmtUpdate = $mysqli->prepare("
        UPDATE dondat 
        SET trangThaiTT = 'Đã thanh toán', 
            phuongThucTT = ?,
            thoiGianThanhToan = NOW()
        WHERE maDon = ? AND trangThaiTT = 'Chờ thanh toán'
    ");
    $stmtUpdate->bind_param("si", $phuongThuc, $maDon);

    if ($stmtUpdate->execute() && $stmtUpdate->affected_rows > 0) {
        $thanhCong = true;
    }
}

if (!empty($_POST['payment_method']) && !isset($_POST['xacNhanThanhToan'])) {
    $anhQR = $_POST['payment_method'] === 'MoMo'
        ? '../../assets/img/qr-momo.png'
        : '../../assets/img/qr-vnpay.png';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <title>Thanh toán</title>
    <link rel="stylesheet" href="../../assets/css/khachhang.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <main>
        <div class="breadcrumb-box">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb tour-breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="trangChu.php" class="breadcrumb-link">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="tour_ChiTiet.php?id=<?= $don['maTour'] ?>" class="breadcrumb-link">
                                <?= htmlspecialchars($don['tenTour']) ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Thanh toán</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container my-4">
            <div class="row">
                <!-- BOX CHỌN THANH TOÁN -->
                <div class="col-lg-6">
                    <div class="box">
                        <h5>Chọn phương thức thanh toán</h5>
                        <form method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <button class="payment-option <?= ($_POST['payment_method'] ?? '') === 'MoMo' ? 'active' : '' ?>"
                                        name="payment_method" value="MoMo">MoMo</button>
                                </div>
                                <div class="col-6">
                                    <button class="payment-option <?= ($_POST['payment_method'] ?? '') === 'VNPay' ? 'active' : '' ?>"
                                        name="payment_method" value="VNPay">VNPay</button>
                                </div>
                            </div>
                        </form>

                        <?php if (!empty($anhQR)): ?>
                            <div class="qr-box mt-3 text-center">
                                <p>Quét mã QR để thanh toán</p>
                                <img src="<?= $anhQR ?>" alt="QR Code" style="width:200px;">
                                <br>
                                <form method="POST">
                                    <input type="hidden" name="payment_method" value="<?= htmlspecialchars($_POST['payment_method']) ?>">
                                    <input type="hidden" name="xacNhanThanhToan" value="1">
                                    <button class="btn btn-pay text-white mt-3">
                                        Thanh toán đã hoàn tất
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- BOX THÔNG TIN ĐƠN -->
                <div class="col-lg-6">
                    <div class="box">
                        <h5 class="text-danger">
                            Đơn đặt của bạn đã được tạm khóa – còn 
                            <span id="countdown">--:--</span>
                        </h5>
                        <hr>
                        <p><strong>Tour:</strong> <?= htmlspecialchars($don['tenTour']) ?></p>
                        <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($don['ngayKhoiHanh'])) ?></p>
                        <p><strong>Số người:</strong> <?= $don['soNguoi'] ?></p>
                        <p><strong>Họ tên:</strong> <?= htmlspecialchars($don['hoTen']) ?></p>
                        <p><strong>SĐT:</strong> <?= htmlspecialchars($don['soDienThoai']) ?></p>
                        <hr>
                        <h5><strong>Tổng tiền:</strong>
                            <span class="price"><?= number_format($don['tongTien'], 0, ',', '.') ?>đ</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- POPUP CẢM ƠN -->
    <div class="modal fade" id="successModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 text-center">
                <h4 class="mb-3">Thanh toán thành công</h4>
                <p>
                    Cảm ơn bạn đã lựa chọn dịch vụ của chúng tôi.
                    Đơn đặt tour của bạn đã được ghi nhận thành công và đang được xử lý.
                    Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận chuyến đi.
                </p>
                <a href="trangChu.php" class="btn btn-success mt-3">Quay trở lại trang chủ</a>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script>
        var giayConLai = <?= intval($giayConLai) ?>;

        function capNhatDongHo() {
            if (giayConLai <= 0) {
                document.getElementById('countdown').textContent = '00:00';
                // Reload để PHP xử lý hết hạn và redirect
                window.location.reload();
                return;
            }

            var phut = Math.floor(giayConLai / 60);
            var giay = giayConLai % 60;
            document.getElementById('countdown').textContent =
                String(phut).padStart(2, '0') + ':' + String(giay).padStart(2, '0');

            giayConLai--;
        }

        capNhatDongHo();
        setInterval(capNhatDongHo, 1000);
    </script>

    <?php if ($thanhCong): ?>
        <script>
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        </script>
    <?php endif; ?>
</body>
</html>