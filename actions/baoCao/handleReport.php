<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

$id     = $_POST['id'] ?? $_GET['id'] ?? '';
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if (!$id || !in_array($action, ['xu_ly', 'xoa'])) {
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php');
    exit();
}

$stmt = $mysqli->prepare("SELECT maBaoCao, maTour FROM baocao WHERE maBaoCao = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$baoCao = $stmt->get_result()->fetch_assoc();

if (!$baoCao) {
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php');
    exit();
}

if ($action === 'xu_ly') {
    $stmt = $mysqli->prepare("UPDATE baocao SET trangThaiXuLy = 'daXuLy' WHERE maBaoCao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $mysqli->prepare("UPDATE tour SET trangThai = 'Tạm dừng' WHERE maTour = ?");
    $stmt->bind_param("i", $baoCao['maTour']);
    $stmt->execute();

    // Gửi phản hồi cho nhà phân phối sở hữu tour
    $lyDo = trim($_POST['noiDungPhanHoi'] ?? '');

    if (!empty($lyDo)) {

        // Lấy thông tin tour
        $stmt = $mysqli->prepare("
        SELECT maND, tenTour
        FROM tour
        WHERE maTour = ?
    ");
        $stmt->bind_param("i", $baoCao['maTour']);
        $stmt->execute();
        $tour = $stmt->get_result()->fetch_assoc();

        if ($tour) {

            $maNPP = $tour['maND'];

            $noiDungPhanHoi =
                'Tour "' . $tour['tenTour'] .
                '" đã bị báo cáo và tạm dừng. Lý do: ' .
                $lyDo;

            $stmt = $mysqli->prepare("
            INSERT INTO phanhoi
            (maND, maBaoCao, noiDung, ngayGui, trangThai)
            VALUES (?, ?, ?, NOW(), 'chuaXem')
        ");

            $stmt->bind_param(
                "iis",
                $maNPP,
                $id,
                $noiDungPhanHoi
            );

            $stmt->execute();
        }
    }
    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php?success=da_xu_ly');
    exit();
} elseif ($action === 'xoa') {
    $stmt = $mysqli->prepare("DELETE FROM phanhoi WHERE maBaoCao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt = $mysqli->prepare("DELETE FROM baocao WHERE maBaoCao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: ../../pages/admin/quanLyBaoCaoViPham.php?success=xoa');
    exit();
}
exit();
