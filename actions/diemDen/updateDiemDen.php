<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/admin/quanLyDiemDen.php');
    exit();
}

$maDiemDen  = trim($_POST['maDiemDen'] ?? '');
$tenDiemDen = trim($_POST['tenDiemDen'] ?? '');
$vungMien   = trim($_POST['vungMien'] ?? '');
$moTa       = trim($_POST['moTa'] ?? '');

$validVung = ['Bắc', 'Trung', 'Nam'];
if (!$maDiemDen || !$tenDiemDen || !in_array($vungMien, $validVung)) {
    header("Location: ../../pages/admin/themDiemDen.php?edit=$maDiemDen&error=thieu_thong_tin");
    exit();
}

// Kiểm tra có upload ảnh mới không
if (!empty($_FILES['anhDiemDen']['name'])) {
    $ext      = pathinfo($_FILES['anhDiemDen']['name'], PATHINFO_EXTENSION);
    $tenFile  = uniqid('dd_') . '.' . $ext;
    $duongDan = '../../assets/img/diemden/' . $tenFile;

    if (!move_uploaded_file($_FILES['anhDiemDen']['tmp_name'], $duongDan)) {
        header("Location: ../../pages/admin/themDiemDen.php?edit=$maDiemDen&error=loi_upload");
        exit();
    }

    $stmt = $mysqli->prepare("UPDATE diemden SET tenDiemDen=?, moTa=?, anhDiemDen=?, vungMien=? WHERE maDiemDen=?");
    $stmt->bind_param("ssssi", $tenDiemDen, $moTa, $tenFile, $vungMien, $maDiemDen);
} else {
    // Giữ ảnh cũ
    $stmt = $mysqli->prepare("UPDATE diemden SET tenDiemDen=?, moTa=?, vungMien=? WHERE maDiemDen=?");
    $stmt->bind_param("sssi", $tenDiemDen, $moTa, $vungMien, $maDiemDen);
}

if ($stmt->execute()) {
    header('Location: ../../pages/admin/quanLyDiemDen.php?success=cap_nhat');
} else {
    header("Location: ../../pages/admin/themDiemDen.php?edit=$maDiemDen&error=loi_he_thong");
}
exit();