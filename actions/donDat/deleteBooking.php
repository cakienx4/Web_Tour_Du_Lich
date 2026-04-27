<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Khách hàng') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$maDon = $_GET['maDon'] ?? '';
if (!$maDon) {
    header('Location: ../../pages/khachHang/lichSuDatTour.php');
    exit();
}

// Kiểm tra đơn thuộc về user này và đúng trạng thái
$stmt = $mysqli->prepare("SELECT maDon, trangThaiTT FROM dondat WHERE maDon = ? AND maND = ?");
$stmt->bind_param("ii", $maDon, $_SESSION['maND']);
$stmt->execute();
$don = $stmt->get_result()->fetch_assoc();

if (!$don || !in_array($don['trangThaiTT'], ['Đã hủy', 'Hết hạn'])) {
    header('Location: ../../pages/khachHang/lichSuDatTour.php');
    exit();
}

$stmt = $mysqli->prepare("DELETE FROM dondat WHERE maDon = ?");
$stmt->bind_param("i", $maDon);

if ($stmt->execute()) {
    header('Location: ../../pages/khachHang/lichSuDatTour.php?success=xoa');
} else {
    header('Location: ../../pages/khachHang/lichSuDatTour.php?error=loi_he_thong');
}
exit();