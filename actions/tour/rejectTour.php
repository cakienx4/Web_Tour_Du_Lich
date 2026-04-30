<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/admin/duyetTour.php');
    exit();
}

$id    = intval($_POST['id'] ?? 0);
$lyDo  = trim($_POST['lyDo'] ?? '');

if (!$id || !$lyDo) {
    header('Location: ../../pages/admin/duyetTour.php?error=missing');
    exit();
}

// Kiểm tra tour tồn tại và đang Chờ duyệt
$stmt = $mysqli->prepare("SELECT maND FROM tour WHERE maTour = ? AND trangThai = 'Chờ duyệt'");
$stmt->bind_param('i', $id);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

if (!$tour) {
    header('Location: ../../pages/admin/duyetTour.php?error=invalid');
    exit();
}

// Tạo baocao tạm để gửi phản hồi cho NPP
$maNDNPP = intval($tour['maND']);
$maNDAdmin = intval($_SESSION['maND']);

$stmt = $mysqli->prepare("INSERT INTO baocao (maND, maTour, noiDung, ngayGui, trangThaiXuLy) VALUES (?, ?, ?, NOW(), 'daXuLy')");
$noiDungBaoCao = 'Tour bị từ chối bởi quản trị viên.';
$stmt->bind_param('iis', $maNDAdmin, $id, $noiDungBaoCao);
$stmt->execute();
$maBaoCao = $mysqli->insert_id;

// Gửi phản hồi lý do từ chối
$stmt = $mysqli->prepare("INSERT INTO phanhoi (maND, maBaoCao, noiDung, ngayGui, trangThai) VALUES (?, ?, ?, NOW(), 'chuaXem')");
$stmt->bind_param('iis', $maNDAdmin, $maBaoCao, $lyDo);
$stmt->execute();

// Xóa tour và các bảng liên quan
$stmt = $mysqli->prepare("DELETE FROM tour_anh WHERE maTour = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM tour_diemden WHERE maTour = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM tour WHERE maTour = ? AND trangThai = 'Chờ duyệt'");
$stmt->bind_param('i', $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    header('Location: ../../pages/admin/duyetTour.php?success=rejected');
} else {
    header('Location: ../../pages/admin/duyetTour.php?error=loi_he_thong');
}
exit();
