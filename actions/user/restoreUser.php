<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$maND = intval($_GET['maND'] ?? 0);

if ($maND <= 0) {
    header('Location: ../../pages/admin/quanLyUsers.php?error=invalid');
    exit();
}

$stmt = $mysqli->prepare("UPDATE user SET trangThai = 'Hoạt động' WHERE maND = ? AND trangThai = 'Vô hiệu hóa'");
$stmt->bind_param('i', $maND);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    header('Location: ../../pages/admin/quanLyUsers.php?error=notfound');
    exit();
}

header('Location: ../../pages/admin/quanLyUsers.php?success=restored');
exit();