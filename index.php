<?php
require_once 'config/database.php';
session_start();

if (isset($_SESSION['vaiTro'])) {
    switch ($_SESSION['vaiTro']) {
        case 'Quản trị viên':
            header('Location: pages/admin/main.php');
            break;
        case 'Nhà phân phối tour':
            header('Location: pages/npp/main.php');
            break;
        case 'Khách hàng':
            header('Location: pages/khachHang/trangChu.php');
            break;
    }
    exit();
}

header('Location: pages/khachHang/trangChu.php');
exit();
?>