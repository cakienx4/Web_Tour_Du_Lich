<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id             = intval($_POST['id'] ?? 0);
$maBaoCao       = intval($_POST['maBaoCao'] ?? 0);
$noiDungPhanHoi = trim($_POST['noiDungPhanHoi'] ?? '');

if (!$id) {
    header('Location: ../../pages/admin/quanLyTourViPham.php');
    exit();
}

$stmt = $mysqli->prepare("SELECT maTour FROM tour WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header('Location: ../../pages/admin/quanLyTourViPham.php');
    exit();
}

// Gửi phản hồi trước khi xóa
if ($maBaoCao && !empty($noiDungPhanHoi)) {
    $maND = intval($_SESSION['maND']);
    $stmt = $mysqli->prepare("INSERT INTO phanhoi (maND, maBaoCao, noiDung, ngayGui, trangThai) VALUES (?, ?, ?, NOW(), 'chuaXem')");
    $stmt->bind_param("iis", $maND, $maBaoCao, $noiDungPhanHoi);
    $stmt->execute();
}

// Hủy đơn 'Chờ thanh toán' và hoàn chỗ trống
$stmt = $mysqli->prepare("
    UPDATE tour t
    JOIN dondat dd ON t.maTour = dd.maTour
    SET t.soChoTrong = t.soChoTrong + dd.soNguoi
    WHERE dd.maTour = ? AND dd.trangThaiTT = 'Chờ thanh toán'
");
$stmt->bind_param("i", $id);
$stmt->execute();

// Hủy tất cả đơn còn active (Chờ thanh toán + Đã thanh toán)
$stmt = $mysqli->prepare("
    UPDATE dondat SET trangThaiTT = 'Đã hủy'
    WHERE maTour = ? AND trangThaiTT IN ('Chờ thanh toán', 'Đã thanh toán')
");
$stmt->bind_param("i", $id);
$stmt->execute();

// Xóa các bảng liên quan
$stmt = $mysqli->prepare("DELETE FROM tour_anh WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM tour_diemden WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM phanhoi WHERE maBaoCao IN (SELECT maBaoCao FROM baocao WHERE maTour = ?)");
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM baocao WHERE maTour = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Giữ lại dondat để khách hàng xem lịch sử, chỉ xóa tour
$stmt = $mysqli->prepare("DELETE FROM tour WHERE maTour = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: ../../pages/admin/quanLyTourViPham.php?success=go_tour');
} else {
    header('Location: ../../pages/admin/quanLyTourViPham.php?error=loi_he_thong');
}
exit();