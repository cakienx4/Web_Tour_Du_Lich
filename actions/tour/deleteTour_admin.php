<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id             = intval($_REQUEST['id'] ?? 0);
$maBaoCao       = intval($_REQUEST['maBaoCao'] ?? 0);
$noiDungPhanHoi = trim($_REQUEST['noiDungPhanHoi'] ?? '');
$from           = trim($_REQUEST['from'] ?? ''); 

// Xác định trang quay lại mặc định dựa trên nguồn gửi
$redirectUrl = '../../pages/admin/quanLyTourViPham.php';
if ($from === 'quanLyTours') {
    $redirectUrl = '../../pages/admin/quanLyTours.php';
}

if (!$id) {
    header('Location: ' . $redirectUrl);
    exit();
}

$stmt = $mysqli->prepare("SELECT maTour FROM tour WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header('Location: ' . $redirectUrl);
    exit();
}

// Gửi phản hồi trước khi xóa (nếu có báo cáo vi phạm)
if ($maBaoCao && !empty($noiDungPhanHoi)) {

    // Lấy thông tin tour
    $stmt = $mysqli->prepare("
        SELECT t.tenTour, t.maND
        FROM tour t
        WHERE t.maTour = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $tour = $stmt->get_result()->fetch_assoc();

    $maNPP = $tour['maND'];

    $noiDung =
        'Tour "' . $tour['tenTour'] .
        '" đã bị từ chối. Lý do: ' .
        $noiDungPhanHoi;

    $stmt = $mysqli->prepare("
        INSERT INTO phanhoi
        (maND, maBaoCao, noiDung, ngayGui, trangThai)
        VALUES (?, ?, ?, NOW(), 'chuaXem')
    ");

    $stmt->bind_param(
        "iis",
        $maNPP,
        $maBaoCao,
        $noiDung
    );

    $stmt->execute();
}

// Hủy đơn 'Chờ thanh toán' và hoàn lại số chỗ trống cho tour
$stmt = $mysqli->prepare("
    UPDATE tour t
    JOIN dondat dd ON t.maTour = dd.maTour
    SET t.soChoTrong = t.soChoTrong + dd.soNguoi
    WHERE dd.maTour = ? AND dd.trangThaiTT = 'Chờ thanh toán'
");
$stmt->bind_param("i", $id);
$stmt->execute();

// Hủy tất cả các đơn đặt hàng còn hoạt động liên quan đến tour này
$stmt = $mysqli->prepare("
    UPDATE dondat SET trangThaiTT = 'Đã hủy'
    WHERE maTour = ? AND trangThaiTT IN ('Chờ thanh toán', 'Đã thanh toán')
");
$stmt->bind_param("i", $id);
$stmt->execute();

// Xóa sạch dữ liệu lưu trữ ở các bảng liên quan đến tour để tránh lỗi khóa ngoại (Foreign Key)
$stmt = $mysqli->prepare("DELETE FROM tour_anh WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM tour_diemden WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM phanhoi WHERE maBaoCao IN (SELECT maBaoCao FROM baocao WHERE maTour = ?)");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM baocao WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Thực hiện xóa hoàn toàn bản ghi Tour khỏi hệ thống
$stmt = $mysqli->prepare("DELETE FROM tour WHERE maTour = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: ' . $redirectUrl . '?success=go_tour');
} else {
    header('Location: ' . $redirectUrl . '?error=loi_he_thong');
}
exit();
