<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id     = $_GET['id'] ?? '';
$action = $_GET['action'] ?? '';

if (!$id || !in_array($action, ['xu_ly', 'xoa'])) {
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php');
    exit();
}

// Kiểm tra báo cáo tồn tại
$stmt = $mysqli->prepare("SELECT maBaoCao FROM baocao WHERE maBaoCao = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php');
    exit();
}

if ($action === 'xu_ly') {
    // Đánh dấu báo cáo đã xử lý
    $stmt = $mysqli->prepare("UPDATE baocao SET trangThaiXuLy = 'daXuLy' WHERE maBaoCao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Lấy maTour từ báo cáo
    $stmt = $mysqli->prepare("SELECT maTour FROM baocao WHERE maBaoCao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $baoCao = $stmt->get_result()->fetch_assoc();

    // Chuyển tour sang Tạm dừng
    $stmt = $mysqli->prepare("UPDATE tour SET trangThai = 'Tạm dừng' WHERE maTour = ?");
    $stmt->bind_param("i", $baoCao['maTour']);
    $stmt->execute();

    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php?success=da_xu_ly');
    exit();
} elseif ($action === 'xoa') {
    // Xóa phản hồi liên quan trước
    $stmt = $mysqli->prepare("DELETE FROM phanhoi WHERE maBaoCao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $mysqli->prepare("DELETE FROM baocao WHERE maBaoCao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php?success=xoa');
}
exit();
