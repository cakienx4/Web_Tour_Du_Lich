<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/admin/quanLyUsers.php');
    exit();
}

$hoTen = trim($_POST['hoTen'] ?? '');
$email = trim($_POST['email'] ?? '');
$soDienThoai = trim($_POST['soDienThoai'] ?? '');
$matKhau = $_POST['matKhau'] ?? '';
$vaiTro = trim($_POST['vaiTro'] ?? '');
$diaChi       = trim($_POST['diaChi'] ?? '');
$tenCongTy    = trim($_POST['tenCongTy'] ?? '');
$diaChiCongTy = trim($_POST['diaChiCongTy'] ?? '');

$validRoles = ['Khách hàng', 'Nhà phân phối tour', 'Quản trị viên'];
if (!$hoTen || !$email || !$soDienThoai || !$matKhau || !in_array($vaiTro, $validRoles)) {
    header('Location: ../../pages/admin/themUsers.php?error=thieu_thong_tin');
    exit();
}

$stmt = $mysqli->prepare("SELECT maND FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    header('Location: ../../pages/admin/themUsers.php?error=email_ton_tai');
    exit();
}

$hash = password_hash($matKhau, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("INSERT INTO user (hoTen, email, soDienThoai, matKhau, vaiTro, diaChi, tenCongTy, diaChiCongTy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $hoTen, $email, $soDienThoai, $hash, $vaiTro, $diaChi, $tenCongTy, $diaChiCongTy);

if ($stmt->execute()) {
    header('Location: ../../pages/admin/quanLyUsers.php?success=them_moi');
} else {
    header('Location: ../../pages/admin/themUsers.php?error=loi_he_thong');
}
exit();