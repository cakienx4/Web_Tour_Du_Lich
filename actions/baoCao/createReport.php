<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Khách hàng') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/khachHang/tour.php');
    exit();
}

$maTour = $_POST['maTour'] ?? null;
$lyDo = $_POST['lyDo'] ?? '';
$noiDung = trim($_POST['noiDung'] ?? '');

if (!$maTour || empty($lyDo) || empty($noiDung)) {
    header('Location: ../../pages/khachHang/tour_ChiTiet.php?id=' . $maTour . '&error=thieu_thong_tin');
    exit();
}

// Gộp lý do và nội dung
$noiDungDayDu = $lyDo . ': ' . $noiDung;

$stmt = $mysqli->prepare("
    INSERT INTO baocao (maND, maTour, noiDung, ngayGui, trangThaiXuLy)
    VALUES (?, ?, ?, CURDATE(), 'choPhanHoi')
");
$stmt->bind_param("iis", $_SESSION['maND'], $maTour, $noiDungDayDu);

if ($stmt->execute()) {
    header('Location: ../../pages/khachHang/tour_ChiTiet.php?id=' . $maTour . '&baocao=1');
} else {
    header('Location: ../../pages/khachHang/tour_ChiTiet.php?id=' . $maTour . '&error=loi_he_thong');
}
exit();
?>