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

if ($maND === intval($_SESSION['maND'])) {
    header('Location: ../../pages/admin/quanLyUsers.php?error=self');
    exit();
}

$stmt = $mysqli->prepare("UPDATE user SET trangThai = 'Vô hiệu hóa' WHERE maND = ?;");
$stmt->bind_param('i', $maND);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    header('Location: ../../pages/admin/quanLyUsers.php?success=deleted');
} else {
    header('Location: ../../pages/admin/quanLyUsers.php?error=notfound');
}
exit();