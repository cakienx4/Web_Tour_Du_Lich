<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/admin/duyetTour.php');
    exit();
}

$id   = intval($_POST['id'] ?? 0);
$lyDo = trim($_POST['lyDo'] ?? '');

if (!$id || !$lyDo) {
    header('Location: ../../pages/admin/duyetTour.php?error=missing');
    exit();
}

// Kiểm tra tour có tồn tại và đang ở trạng thái 'Chờ duyệt' hay không
$stmt = $mysqli->prepare("SELECT maND, tenTour FROM tour WHERE maTour = ? AND trangThai = 'Chờ duyệt'");
$stmt->bind_param('i', $id);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: ../../pages/admin/duyetTour.php?error=invalid');
    exit();
}

$maNDNPP   = intval($tour['maND']);
$tenTour   = $tour['tenTour'];
$maNDAdmin = intval($_SESSION['maND']);

// Gửi phản hồi thông báo lý do từ chối cho Nhà phân phối
$noiDung = 'Tour "' . $tenTour . '" đã bị từ chối. Lý do: ' . $lyDo;
$stmt = $mysqli->prepare("INSERT INTO phanhoi (maND, maBaoCao, noiDung, ngayGui, trangThai) VALUES (?, NULL, ?, NOW(), 'chuaXem')");
$stmt->bind_param('is', $maNDNPP, $noiDung);
$stmt->execute();

// CẬP NHẬT TRẠNG THÁI TOUR SANG 'Bị từ chối'
$stmt = $mysqli->prepare("UPDATE tour SET trangThai = 'Từ chối' WHERE maTour = ? AND trangThai = 'Chờ duyệt'");
$stmt->bind_param('i', $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    header('Location: ../../pages/admin/duyetTour.php?success=rejected');
} else {
    header('Location: ../../pages/admin/duyetTour.php?error=loi_he_thong');
}
exit();
?>