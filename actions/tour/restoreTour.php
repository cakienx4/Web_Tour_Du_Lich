<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: ../../pages/admin/quanLyTourViPham.php');
    exit();
}

// Kiểm tra tour tồn tại
$stmt = $mysqli->prepare("SELECT maTour FROM tour WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header('Location: ../../pages/admin/quanLyTourViPham.php');
    exit();
}

$stmt = $mysqli->prepare("UPDATE tour SET trangThai = 'Đang bán' WHERE maTour = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: ../../pages/admin/quanLyTourViPham.php?success=khoi_phuc');
} else {
    header('Location: ../../pages/admin/quanLyTourViPham.php?error=loi_he_thong');
}
exit();