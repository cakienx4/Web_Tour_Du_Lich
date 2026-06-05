<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id   = intval($_POST['id'] ?? $_GET['id'] ?? 0);
$lyDo = trim($_POST['lyDo'] ?? '');

if (!$id) {
    header('Location: ../../pages/admin/quanLyTours.php?error=invalid');
    exit();
}

// Lấy thông tin tour trước khi đổi trạng thái
$stmt = $mysqli->prepare("SELECT maND, tenTour, trangThai FROM tour WHERE maTour = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: ../../pages/admin/quanLyTours.php?error=invalid');
    exit();
}

// Đổi trạng thái
$stmt = $mysqli->prepare("
    UPDATE tour
    SET trangThai = CASE
        WHEN trangThai = 'Đang bán' THEN 'Tạm dừng'
        WHEN trangThai = 'Tạm dừng' THEN 'Đang bán'
        ELSE trangThai
    END
    WHERE maTour = ?
");
$stmt->bind_param('i', $id);
$stmt->execute();

// Gửi phản hồi cho NPP
$maNDNPP = intval($tour['maND']);

if ($tour['trangThai'] === 'Đang bán' && !empty($lyDo)) {
    // Tạm dừng — kèm lý do
    $noiDung = 'Tour "' . $tour['tenTour'] . '" đã bị tạm dừng. Lý do: ' . $lyDo;
} elseif ($tour['trangThai'] === 'Tạm dừng') {
    // Mở bán lại — không cần lý do
    $noiDung = 'Tour "' . $tour['tenTour'] . '" đã được mở bán lại.';
} else {
    $noiDung = '';
}

if (!empty($noiDung)) {
    $stmt = $mysqli->prepare("INSERT INTO phanhoi (maND, maBaoCao, noiDung, ngayGui, trangThai) VALUES (?, NULL, ?, NOW(), 'chuaXem')");
    $stmt->bind_param('is', $maNDNPP, $noiDung);
    $stmt->execute();
}

header('Location: ../../pages/admin/quanLyTours.php');
exit();