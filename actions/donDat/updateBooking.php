<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$maDon = $_GET['maDon'] ?? null;
if (!$maDon) {
    header('Location: ../../pages/admin/quanLyDonDat.php');
    exit();
}

// Lấy trạng thái hiện tại
$stmt = $mysqli->prepare("SELECT trangThaiTT FROM dondat WHERE maDon = ?");
$stmt->bind_param("i", $maDon);
$stmt->execute();
$don = $stmt->get_result()->fetch_assoc();

if (!$don) {
    header('Location: ../../pages/admin/quanLyDonDat.php');
    exit();
}

// Toggle tuần tự
$trangThaiMoi = match($don['trangThaiTT']) {
    'Chờ thanh toán' => 'Đã thanh toán',
    'Đã thanh toán'  => 'Hết hạn',
    'Hết hạn'        => 'Đã thanh toán',
    default          => null // Đã hủy không toggle
};

if (!$trangThaiMoi) {
    header('Location: ../../pages/admin/quanLyDonDat.php');
    exit();
}

$stmt = $mysqli->prepare("UPDATE dondat SET trangThaiTT = ? WHERE maDon = ?");
$stmt->bind_param("si", $trangThaiMoi, $maDon);
$stmt->execute();

header('Location: ../../pages/admin/quanLyDonDat.php?success=cap_nhat');
exit();