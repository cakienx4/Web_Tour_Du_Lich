<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/khachHang/hoSo.php');
    exit();
}

$hoTen = trim($_POST['hoTen'] ?? '');
$email = trim($_POST['email'] ?? '');
$soDienThoai = trim($_POST['soDienThoai'] ?? '');
$matKhau = $_POST['matKhau'] ?? '';

if (empty($hoTen) || empty($email) || empty($soDienThoai)) {
    header('Location: ../../pages/khachHang/hoSo.php?mode=edit&error=thieu_thong_tin');
    exit();
}

// Kiểm tra email đã tồn tại chưa (trừ chính mình)
$stmtCheck = $mysqli->prepare("SELECT maND FROM user WHERE email = ? AND maND != ?");
$stmtCheck->bind_param("si", $email, $_SESSION['maND']);
$stmtCheck->execute();
if ($stmtCheck->get_result()->num_rows > 0) {
    header('Location: ../../pages/khachHang/hoSo.php?mode=edit&error=email_ton_tai');
    exit();
}

// Có đổi mật khẩu không
if (!empty($matKhau)) {
    $hashedPassword = password_hash($matKhau, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("
        UPDATE user SET hoTen = ?, email = ?, soDienThoai = ?, matKhau = ?
        WHERE maND = ?
    ");
    $stmt->bind_param("ssssi", $hoTen, $email, $soDienThoai, $hashedPassword, $_SESSION['maND']);
} else {
    $stmt = $mysqli->prepare("
        UPDATE user SET hoTen = ?, email = ?, soDienThoai = ?
        WHERE maND = ?
    ");
    $stmt->bind_param("sssi", $hoTen, $email, $soDienThoai, $_SESSION['maND']);
}

if ($stmt->execute()) {
    // Cập nhật session nếu đổi tên
    $_SESSION['hoTen'] = $hoTen;
    header('Location: ../../pages/khachHang/hoSo.php?success=1');
} else {
    header('Location: ../../pages/khachHang/hoSo.php?mode=edit&error=loi_he_thong');
}
exit();
?>