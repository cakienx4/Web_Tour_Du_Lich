<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id = intval($_GET['id'] ?? 0);

if (!$id) {
    header('Location: ../../pages/admin/duyetTour.php?error=missing_id');
    exit();
}

// Kiểm tra tour tồn tại và đang Chờ duyệt
$stmt = $mysqli->prepare("SELECT maND, tenTour FROM tour WHERE maTour = ? AND trangThai = 'Chờ duyệt'");
$stmt->bind_param('i', $id);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: ../../pages/admin/duyetTour.php?error=invalid');
    exit();
}

$maNDNPP = intval($tour['maND']);
$tenTour = $tour['tenTour'];

// Duyệt tour
$stmt = $mysqli->prepare("UPDATE tour SET trangThai = 'Đang bán' WHERE maTour = ? AND trangThai = 'Chờ duyệt'");
$stmt->bind_param('i', $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    // Gửi phản hồi cho NPP
    $noiDung = 'Tour đã được duyệt và đang bán.';
    $stmt = $mysqli->prepare("INSERT INTO phanhoi (maND, maBaoCao, noiDung, ngayGui, trangThai) VALUES (?, NULL, ?, NOW(), 'chuaXem')");
    $stmt->bind_param('is', $maNDNPP, $noiDung);
    $stmt->execute();

    header('Location: ../../pages/admin/duyetTour.php?success=approved');
} else {
    header('Location: ../../pages/admin/duyetTour.php?error=loi_he_thong');
}
exit();