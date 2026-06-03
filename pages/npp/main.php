<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang nhà phân phối</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
        <style>
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
            background-color: #eef0f3;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php include "../../includes/sideBar-NPP.php"; ?>

            <div class="main-content">
                <div class="text-center">
                    <h3 class="text-title">
                        CHÀO MỪNG NHÀ PHÂN PHỐI ĐẾN VỚI HỆ THỐNG!
                    </h3>
                    <p class="mt-3 text-muted">
                        Hãy lựa chọn chức năng ở sidebar bên trái để quản lý tour,
                        theo dõi đơn đặt và thống kê doanh thu.
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>