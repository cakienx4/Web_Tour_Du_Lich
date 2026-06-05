<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id        = intval($_POST['id'] ?? 0);
$maBaoCao  = intval($_POST['maBaoCao'] ?? 0);
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

$stmt = $mysqli->prepare("UPDATE tour SET trangThai = 'Đang bán' WHERE maTour = ?");
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    header('Location: ../../pages/admin/quanLyTourViPham.php?error=loi_he_thong');
    exit();
}

// Gửi phản hồi nếu có
if ($maBaoCao && !empty($noiDungPhanHoi)) {

    $stmt = $mysqli->prepare("
        SELECT t.tenTour, t.maND
        FROM tour t
        WHERE t.maTour = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $tour = $stmt->get_result()->fetch_assoc();

    $maNPP = $tour['maND'];

    $noiDung =
        'Tour "' . $tour['tenTour'] .
        '" đã được khôi phục. ' .
        $noiDungPhanHoi;

    $stmt = $mysqli->prepare("
        INSERT INTO phanhoi
        (maND, maBaoCao, noiDung, ngayGui, trangThai)
        VALUES (?, ?, ?, NOW(), 'chuaXem')
    ");

    $stmt->bind_param(
        "iis",
        $maNPP,
        $maBaoCao,
        $noiDung
    );

    $stmt->execute();
}

header('Location: ../../pages/admin/quanLyTourViPham.php?success=khoi_phuc');
exit();