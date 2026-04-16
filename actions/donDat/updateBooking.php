<?php
require_once '../../config/database.php';

$maDon = $_GET['maDon'] ?? null;

if (!$maDon) {
    header("Location: ../../pages/admin/quanLyDonDat.php");
    exit;
}

// Ví dụ: chuyển sang đã thanh toán
$stmt = $mysqli->prepare("
    UPDATE dondat 
    SET trangThaiTT = 'daThanhToan'
    WHERE maDon = ?
");

$stmt->bind_param("i", $maDon);
$stmt->execute();

header("Location: ../../pages/admin/quanLyDonDat.php");
exit;