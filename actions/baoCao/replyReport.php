<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php');
    exit();
}

$maBaoCao = trim($_POST['maBaoCao'] ?? '');
$noiDung  = trim($_POST['noiDung'] ?? '');

if (!$maBaoCao || !$noiDung) {
    header("Location: ../../pages/admin/chiTietBaoCao.php?id=$maBaoCao&error=thieu_thong_tin");
    exit();
}

// Kiểm tra báo cáo tồn tại
$stmt = $mysqli->prepare("SELECT maBaoCao FROM baocao WHERE maBaoCao = ?");
$stmt->bind_param("i", $maBaoCao);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php');
    exit();
}

$maND = $_SESSION['maND'];
$stmt = $mysqli->prepare("INSERT INTO phanhoi (maND, maBaoCao, noiDung, ngayGui, trangThai) VALUES (?, ?, ?, NOW(), 'chuaXem')");
$stmt->bind_param("iis", $maND, $maBaoCao, $noiDung);

if ($stmt->execute()) {
    header("Location: ../../pages/admin/chiTietBaoCao.php?id=$maBaoCao&success=1");
} else {
    header("Location: ../../pages/admin/chiTietBaoCao.php?id=$maBaoCao&error=loi_he_thong");
}
exit();
