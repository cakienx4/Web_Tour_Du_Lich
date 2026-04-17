<?php
session_start();
require_once '../../config/database.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: ../../pages/admin/quanLyDiemDen.php');
    exit();
}

// Lấy tên file ảnh để xóa khỏi server
$stmt = $mysqli->prepare("SELECT anhDiemDen FROM diemden WHERE maDiemDen = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dd = $stmt->get_result()->fetch_assoc();

if (!$dd) {
    header('Location: ../../pages/admin/quanLyDiemDen.php');
    exit();
}

$stmt = $mysqli->prepare("DELETE FROM diemden WHERE maDiemDen = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Xóa file ảnh nếu tồn tại
    $filePath = '../../assets/img/diemden/' . $dd['anhDiemDen'];
    if (file_exists($filePath)) unlink($filePath);

    header('Location: ../../pages/admin/quanLyDiemDen.php?success=xoa');
} else {
    header('Location: ../../pages/admin/quanLyDiemDen.php?error=loi_he_thong');
}
exit();