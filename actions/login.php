<?php
session_start();
require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
    header("Location: ../pages/auth/dangNhap.php");
    exit();
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['matKhau'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
    header("Location: ../pages/auth/dangNhap.php");
    exit();
}

$stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || !password_verify($password, $user['matKhau'])) {
    $_SESSION['error'] = 'Sai email hoặc mật khẩu!';
    header("Location: ../pages/auth/dangNhap.php");
    exit();
}

if ($user['trangThai'] === 'Vô hiệu hóa') {
    $_SESSION['error'] = 'Tài khoản đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên.';
    header("Location: ../pages/auth/dangNhap.php");
    exit();
}

$_SESSION['maND']  = $user['maND'];
$_SESSION['hoTen'] = $user['hoTen'];
$_SESSION['vaiTro'] = $user['vaiTro'];

if ($user['vaiTro'] === 'Quản trị viên') {
    header("Location: ../pages/admin/main.php");
} elseif ($user['vaiTro'] === 'Nhà phân phối tour') {
    header("Location: ../pages/npp/main.php");
} else {
    header("Location: ../pages/khachHang/trangChu.php");
}
exit();
