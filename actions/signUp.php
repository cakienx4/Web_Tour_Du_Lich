<?php
require_once "../../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hoTen = $_POST['hoTen'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['matKhau'] ?? '';
    $confirmPassword = $_POST['confirmMatKhau'] ?? '';
    $soDienThoai = $_POST['soDienThoai'] ?? '';

    if (empty($hoTen) || empty($email) || empty($password) || empty($soDienThoai)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } elseif ($password !== $confirmPassword) {
        $error = "Mật khẩu không khớp!";
    } else {
        $stmt = $mysqli->prepare("SELECT maND FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email đã tồn tại!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $mysqli->prepare("
                INSERT INTO user (email, matKhau, hoTen, soDienThoai, vaiTro)
                VALUES (?, ?, ?, ?, 'Khách hàng')
            ");
            $stmt->bind_param("ssss", $email, $hashedPassword, $hoTen, $soDienThoai);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Đăng ký thành công!</p>";
            } else {
                $error = "Lỗi hệ thống!";
            }
        }
    }
}
?>