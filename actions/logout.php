<?php
session_start();

// Xoá toàn bộ biến session
session_unset();

// Huỷ session
session_destroy();

// Điều hướng về trang chủ khách
header("Location: ../pages/khachHang/trangChu.php");
exit();
?>