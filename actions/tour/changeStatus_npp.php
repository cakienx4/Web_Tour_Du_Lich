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

$stmt = $mysqli->prepare("
    UPDATE tour
    SET trangThai = CASE
        WHEN trangThai = 'Đang bán' THEN 'Tạm dừng'
        WHEN trangThai = 'Tạm dừng' THEN 'Đang bán'
        ELSE trangThai
    END
    WHERE maTour = ? AND maND = ? AND trangThai IN ('Đang bán', 'Tạm dừng')
");
$stmt->bind_param('ii', $maTour, $maND);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    header('Location: ../../pages/npp/quanLyTours.php?error=invalid');
    exit();
}

header('Location: ../../pages/npp/quanLyTours.php?success=updated');
exit();