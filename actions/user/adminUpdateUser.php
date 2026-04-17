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

$maND = trim($_POST['maND'] ?? '');
$hoTen = trim($_POST['hoTen'] ?? '');
$email = trim($_POST['email'] ?? '');
$soDienThoai = trim($_POST['soDienThoai'] ?? '');
$matKhau = $_POST['matKhau'] ?? '';
$vaiTro = trim($_POST['vaiTro'] ?? '');
$diaChi = trim($_POST['diaChi'] ?? '');
$tenCongTy = trim($_POST['tenCongTy'] ?? '');
$diaChiCongTy = trim($_POST['diaChiCongTy'] ?? '');

$validRoles = ['Khách hàng', 'Nhà phân phối tour', 'Quản trị viên'];
if (!$maND || !$hoTen || !$email || !$soDienThoai || !in_array($vaiTro, $validRoles)) {
    header("Location: ../../pages/admin/themUsers.php?edit=$maND&error=thieu_thong_tin");
    exit();
}

// Kiểm tra user tồn tại
$stmt = $mysqli->prepare("SELECT maND FROM user WHERE maND = ?");
$stmt->bind_param("i", $maND);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header('Location: ../../pages/admin/quanLyUsers.php');
    exit();
}

// Kiểm tra email trùng với user khác
$stmt = $mysqli->prepare("SELECT maND FROM user WHERE email = ? AND maND != ?");
$stmt->bind_param("si", $email, $maND);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    header("Location: ../../pages/admin/themUsers.php?edit=$maND&error=email_ton_tai");
    exit();
}

if ($matKhau) {
    $hash = password_hash($matKhau, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("UPDATE user SET hoTen=?, email=?, soDienThoai=?, matKhau=?, vaiTro=?, diaChi=?, tenCongTy=?, diaChiCongTy=? WHERE maND=?");
    $stmt->bind_param("ssssssssi", $hoTen, $email, $soDienThoai, $hash, $vaiTro, $diaChi, $tenCongTy, $diaChiCongTy, $maND);
} else {
    $stmt = $mysqli->prepare("UPDATE user SET hoTen=?, email=?, soDienThoai=?, vaiTro=?, diaChi=?, tenCongTy=?, diaChiCongTy=? WHERE maND=?");
    $stmt->bind_param("sssssssi", $hoTen, $email, $soDienThoai, $vaiTro, $diaChi, $tenCongTy, $diaChiCongTy, $maND);

}

if ($stmt->execute()) {
    header('Location: ../../pages/admin/quanLyUsers.php?success=cap_nhat');
} else {
    header("Location: ../../pages/admin/themUsers.php?edit=$maND&error=loi_he_thong");
}
exit();