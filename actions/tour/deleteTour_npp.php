<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$maTour = intval($_GET['maTour'] ?? 0);
$maND   = intval($_SESSION['maND']);

if ($maTour <= 0) {
    header('Location: ../../pages/npp/quanLyTours.php?error=invalid');
    exit();
}

// Kiểm tra tour thuộc về NPP này và đúng trạng thái
$stmt = $mysqli->prepare("SELECT trangThai FROM tour WHERE maTour = ? AND maND = ?");
$stmt->bind_param('ii', $maTour, $maND);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: ../../pages/npp/quanLyTours.php?error=invalid');
    exit();
}

if (!in_array($tour['trangThai'], ['Chờ duyệt', 'Tạm dừng'])) {
    header('Location: ../../pages/npp/quanLyTours.php?error=cannot_delete');
    exit();
}

// Không cho xóa nếu có đơn Đã thanh toán
$stmt = $mysqli->prepare("SELECT COUNT(*) AS soDon FROM dondat WHERE maTour = ? AND trangThaiTT = 'Đã thanh toán'");
$stmt->bind_param('i', $maTour);
$stmt->execute();
$soDon = $stmt->get_result()->fetch_assoc()['soDon'];

if ($soDon > 0) {
    header('Location: ../../pages/npp/quanLyTours.php?error=cannot_delete');
    exit();
}

// Xóa các bảng liên quan
$stmt = $mysqli->prepare("DELETE FROM tour_anh WHERE maTour = ?");
$stmt->bind_param('i', $maTour);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM tour_diemden WHERE maTour = ?");
$stmt->bind_param('i', $maTour);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM dondat WHERE maTour = ?");
$stmt->bind_param('i', $maTour);
$stmt->execute();

// Xóa tour
$stmt = $mysqli->prepare("DELETE FROM tour WHERE maTour = ? AND maND = ?");
$stmt->bind_param('ii', $maTour, $maND);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    header('Location: ../../pages/npp/quanLyTours.php?success=deleted');
} else {
    header('Location: ../../pages/npp/quanLyTours.php?error=loi_he_thong');
}
exit();