<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php include '../../includes/sideBar-admin.php'; ?>

            <div class="col-md-9 col-lg-10 main-content center-flex">
                <div class="text-center">
                    <h3 class="text-title">
                        CHÀO MỪNG QUẢN TRỊ VIÊN QUAY TRỞ LẠI HỆ THỐNG!
                    </h3>
                    <p class="mt-3 text-muted">
                        Hãy lựa chọn giao diện ở sidebar bên trái để tiếp tục sử dụng các chức năng.
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>