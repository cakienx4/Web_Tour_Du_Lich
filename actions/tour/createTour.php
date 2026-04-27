<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/npp/taoTour.php');
    exit();
}

$maND         = intval($_SESSION['maND']);
$tenTour      = trim($_POST['tenTour'] ?? '');
$giaTour      = floatval($_POST['giaTour'] ?? 0);
$tongSoCho    = intval($_POST['tongSoCho'] ?? 0);
$ngayKhoiHanh = trim($_POST['ngayKhoiHanh'] ?? '');
$soNgay       = intval($_POST['soNgay'] ?? 0);
$diemXuatPhat = trim($_POST['diemXuatPhat'] ?? '');
$maDiemDen    = intval($_POST['maDiemDen'] ?? 0);
$moTa         = trim($_POST['moTa'] ?? '');
$lichTrinh    = trim($_POST['lichTrinh'] ?? '');

if (!$tenTour || !$giaTour || !$tongSoCho || !$ngayKhoiHanh || !$soNgay || !$diemXuatPhat || !$maDiemDen || !$moTa) {
    header('Location: ../../pages/npp/taoTour.php?error=missing');
    exit();
}

if (strtotime($ngayKhoiHanh) <= strtotime('today')) {
    header('Location: ../../pages/npp/taoTour.php?error=date');
    exit();
}

if (!isset($_FILES['anhChinh']) || $_FILES['anhChinh']['error'] !== UPLOAD_ERR_OK) {
    header('Location: ../../pages/npp/taoTour.php?error=upload');
    exit();
}

// Insert tour
$stmt = $mysqli->prepare("
    INSERT INTO tour (maND, tenTour, moTa, lichTrinh, giaTour, ngayKhoiHanh, soNgay, diemXuatPhat, soChoTrong, tongSoCho, trangThai)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Chờ duyệt')
");
$stmt->bind_param('issssdisii', $maND, $tenTour, $moTa, $lichTrinh, $giaTour, $ngayKhoiHanh, $soNgay, $diemXuatPhat, $tongSoCho, $tongSoCho);

if (!$stmt->execute()) {
    header('Location: ../../pages/npp/taoTour.php?error=db');
    exit();
}

$maTour = $mysqli->insert_id;

// Insert tour_diemden
$stmt = $mysqli->prepare("INSERT INTO tour_diemden (maDiemDen, maTour) VALUES (?, ?)");
$stmt->bind_param('ii', $maDiemDen, $maTour);
$stmt->execute();

// Upload ảnh chính
$uploadDir = '../../assets/img/tours/';
$ext = pathinfo($_FILES['anhChinh']['name'], PATHINFO_EXTENSION);
$tenFile = 'tour_' . $maTour . '_main_' . time() . '.' . $ext;

if (!move_uploaded_file($_FILES['anhChinh']['tmp_name'], $uploadDir . $tenFile)) {
    header('Location: ../../pages/npp/taoTour.php?error=upload');
    exit();
}

$duongDan = 'assets/img/tours/' . $tenFile;
$laManhChinh = 1;
$stmt = $mysqli->prepare("INSERT INTO tour_anh (maTour, duongDan, laManhChinh) VALUES (?, ?, ?)");
$stmt->bind_param('isi', $maTour, $duongDan, $laManhChinh);
$stmt->execute();

// Upload ảnh phụ
if (!empty($_FILES['anhPhu']['name'][0])) {
    $laManhChinh = 0;
    foreach ($_FILES['anhPhu']['tmp_name'] as $i => $tmpName) {
        if ($_FILES['anhPhu']['error'][$i] !== UPLOAD_ERR_OK) continue;
        $ext = pathinfo($_FILES['anhPhu']['name'][$i], PATHINFO_EXTENSION);
        $tenFile = 'tour_' . $maTour . '_sub_' . time() . '_' . $i . '.' . $ext;
        if (!move_uploaded_file($tmpName, $uploadDir . $tenFile)) continue;
        $duongDan = 'assets/img/tours/' . $tenFile;
        $stmt = $mysqli->prepare("INSERT INTO tour_anh (maTour, duongDan, laManhChinh) VALUES (?, ?, ?)");
        $stmt->bind_param('isi', $maTour, $duongDan, $laManhChinh);
        $stmt->execute();
    }
}

header('Location: ../../pages/npp/quanLyTours.php?success=created');
exit();
