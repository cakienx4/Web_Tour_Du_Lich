<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/npp/quanLyTours.php');
    exit();
}

$maND         = intval($_SESSION['maND']);
$maTour       = intval($_POST['maTour'] ?? 0);
$tenTour      = trim($_POST['tenTour'] ?? '');
$giaTour      = floatval($_POST['giaTour'] ?? 0);
$tongSoCho    = intval($_POST['tongSoCho'] ?? 0);
$ngayKhoiHanh = trim($_POST['ngayKhoiHanh'] ?? '');
$soNgay       = intval($_POST['soNgay'] ?? 0);
$diemXuatPhat = trim($_POST['diemXuatPhat'] ?? '');
$maDiemDen    = intval($_POST['maDiemDen'] ?? 0);
$moTa         = trim($_POST['moTa'] ?? '');
$lichTrinh    = trim($_POST['lichTrinh'] ?? '');

if (!$maTour || !$tenTour || !$giaTour || !$tongSoCho || !$ngayKhoiHanh || !$soNgay || !$diemXuatPhat || !$maDiemDen || !$moTa) {
    header("Location: ../../pages/npp/suaTour.php?maTour=$maTour&error=missing");
    exit();
}

if (strtotime($ngayKhoiHanh) <= strtotime('today')) {
    header("Location: ../../pages/npp/suaTour.php?maTour=$maTour&error=date");
    exit();
}

// Kiểm tra tour thuộc NPP này và không phải Chờ duyệt
$stmt = $mysqli->prepare("SELECT trangThai FROM tour WHERE maTour = ? AND maND = ? AND trangThai != 'Chờ duyệt'");
$stmt->bind_param('ii', $maTour, $maND);
$stmt->execute();
if (!$stmt->get_result()->fetch_assoc()) {
    header('Location: ../../pages/npp/quanLyTours.php?error=invalid');
    exit();
}

// Tính lại soChoTrong: soChoTrong mới = tongSoCho mới - số người đã đặt thành công
$stmt = $mysqli->prepare("
    SELECT COALESCE(SUM(soNguoi), 0) AS daDat FROM dondat
    WHERE maTour = ? AND trangThaiTT = 'Đã thanh toán'
");
$stmt->bind_param('i', $maTour);
$stmt->execute();
$daDat = intval($stmt->get_result()->fetch_assoc()['daDat']);
$soChoTrong = max(0, $tongSoCho - $daDat);

// Update tour
$stmt = $mysqli->prepare("
    UPDATE tour SET tenTour=?, moTa=?, lichTrinh=?, giaTour=?, ngayKhoiHanh=?,
    soNgay=?, diemXuatPhat=?, tongSoCho=?, soChoTrong=?
    WHERE maTour = ? AND maND = ?
");
$stmt->bind_param('ssssdisiiii', $tenTour, $moTa, $lichTrinh, $giaTour, $ngayKhoiHanh, $soNgay, $diemXuatPhat, $tongSoCho, $soChoTrong, $maTour, $maND);

if (!$stmt->execute()) {
    header("Location: ../../pages/npp/suaTour.php?maTour=$maTour&error=db");
    exit();
}

// Update điểm đến
$stmt = $mysqli->prepare("UPDATE tour_diemden SET maDiemDen = ? WHERE maTour = ?");
$stmt->bind_param('ii', $maDiemDen, $maTour);
$stmt->execute();

// Upload ảnh chính mới nếu có
if (isset($_FILES['anhChinh']) && $_FILES['anhChinh']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../assets/img/tours/';
    $ext = pathinfo($_FILES['anhChinh']['name'], PATHINFO_EXTENSION);
    $tenFile = 'tour_' . $maTour . '_main_' . time() . '.' . $ext;

    if (move_uploaded_file($_FILES['anhChinh']['tmp_name'], $uploadDir . $tenFile)) {
        // Xóa ảnh chính cũ
        $stmt = $mysqli->prepare("DELETE FROM tour_anh WHERE maTour = ? AND laManhChinh = 1");
        $stmt->bind_param('i', $maTour);
        $stmt->execute();

        $duongDan = 'assets/img/tours/' . $tenFile;
        $laManhChinh = 1;
        $stmt = $mysqli->prepare("INSERT INTO tour_anh (maTour, duongDan, laManhChinh) VALUES (?, ?, ?)");
        $stmt->bind_param('isi', $maTour, $duongDan, $laManhChinh);
        $stmt->execute();
    }
}

// Upload ảnh phụ mới nếu có
if (!empty($_FILES['anhPhu']['name'][0])) {
    $laManhChinh = 0;
    $uploadDir = '../../assets/img/tours/';
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

header("Location: ../../pages/npp/chiTietTour.php?maTour=$maTour&success=updated");
exit();