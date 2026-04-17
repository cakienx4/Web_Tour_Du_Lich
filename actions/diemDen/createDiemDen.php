<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/admin/quanLyDiemDen.php');
    exit();
}

$tenDiemDen = trim($_POST['tenDiemDen'] ?? '');
$vungMien   = trim($_POST['vungMien'] ?? '');
$moTa       = trim($_POST['moTa'] ?? '');

$validVung = ['Bắc', 'Trung', 'Nam'];
if (!$tenDiemDen || !in_array($vungMien, $validVung) || empty($_FILES['anhDiemDen']['name'])) {
    header('Location: ../../pages/admin/themDiemDen.php?error=thieu_thong_tin');
    exit();
}

// Upload ảnh
$ext      = pathinfo($_FILES['anhDiemDen']['name'], PATHINFO_EXTENSION);
$tenFile  = uniqid('dd_') . '.' . $ext;
$duongDan = '../../assets/img/diemden/' . $tenFile;

if (!move_uploaded_file($_FILES['anhDiemDen']['tmp_name'], $duongDan)) {
    header('Location: ../../pages/admin/themDiemDen.php?error=loi_upload');
    exit();
}

$stmt = $mysqli->prepare("INSERT INTO diemden (tenDiemDen, moTa, anhDiemDen, vungMien) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $tenDiemDen, $moTa, $tenFile, $vungMien);

if ($stmt->execute()) {
    header('Location: ../../pages/admin/quanLyDiemDen.php?success=them_moi');
} else {
    header('Location: ../../pages/admin/themDiemDen.php?error=loi_he_thong');
}
exit();