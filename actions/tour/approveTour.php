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

$stmt = $mysqli->prepare("UPDATE tour SET trangThai = 'Đang bán' WHERE maTour = ? AND trangThai = 'Chờ duyệt'");
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    header('Location: ../../pages/admin/duyetTour.php?error=invalid');
    exit();
}

header('Location: ../../pages/admin/duyetTour.php?success=approved');
exit();
