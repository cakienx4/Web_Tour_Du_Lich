<?php
session_start();
require_once "../../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['matKhau'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {

        $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['matKhau'])) {

            $_SESSION['maND'] = $user['maND'];
            $_SESSION['hoTen'] = $user['hoTen'];
            $_SESSION['vaiTro'] = $user['vaiTro'];

            if ($user['vaiTro'] == 'Quản trị viên') {
                header("Location: ../admin/main.php");
            } elseif ($user['vaiTro'] == 'Nhà phân phối tour') {
                header("Location: ../npp/main.php");
            } else {
                header("Location: ../khachHang/trangChu.php");
            }
            exit();

        } else {
            $error = "Sai email hoặc mật khẩu!";
        }
    }
}
?>