<?php
session_start();
require_once '../../config/database.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Khách hàng') {
    header('Location: ../../pages/auth/dangNhap.php');
    exit();
}

// Kiểm tra request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/khachHang/tour.php');
    exit();
}

// Nhận dữ liệu từ form
$maTour = $_POST['maTour'] ?? null;
$soNguoi = intval($_POST['soNguoi'] ?? 1);

if (!$maTour || $soNguoi < 1) {
    header('Location: ../../pages/khachHang/tour.php');
    exit();
}

// =============================================
// DỌN DẸP ĐƠN QUÁ 10 PHÚT CHƯA THANH TOÁN
// =============================================
$stmtDonQuaHan = $mysqli->prepare("
    SELECT maDon, maTour, soNguoi FROM dondat
    WHERE trangThaiTT = 'choPhanHoi'
    AND TIMESTAMPDIFF(MINUTE, thoiGianDat, NOW()) > 10
");
$stmtDonQuaHan->execute();
$donQuaHan = $stmtDonQuaHan->get_result();

while ($don = $donQuaHan->fetch_assoc()) {
    // Hoàn lại số chỗ trống
    $stmtHoan = $mysqli->prepare("
        UPDATE tour SET soChoTrong = soChoTrong + ?,
        trangThai = CASE 
            WHEN trangThai = 'Tạm dừng' THEN 'Đang bán'
            ELSE trangThai 
        END
        WHERE maTour = ?
    ");
    $stmtHoan->bind_param("ii", $don['soNguoi'], $don['maTour']);
    $stmtHoan->execute();

    // Xóa đơn quá hạn
    $stmtXoa = $mysqli->prepare("DELETE FROM dondat WHERE maDon = ?");
    $stmtXoa->bind_param("i", $don['maDon']);
    $stmtXoa->execute();
}

// =============================================
// LẤY THÔNG TIN TOUR
// =============================================
$stmt = $mysqli->prepare("
    SELECT maTour, giaTour, soChoTrong, tongSoCho, ngayKhoiHanh, trangThai
    FROM tour WHERE maTour = ?
");
$stmt->bind_param("i", $maTour);
$stmt->execute();
$tour = $stmt->get_result()->fetch_assoc();

// Kiểm tra tour hợp lệ
if (!$tour || $tour['trangThai'] !== 'Đang bán') {
    header('Location: ../../pages/khachHang/tour.php');
    exit();
}

// Kiểm tra còn đủ chỗ không
if ($soNguoi > $tour['soChoTrong']) {
    header('Location: ../../pages/khachHang/datTour.php?id=' . $maTour . '&error=khong_du_cho');
    exit();
}

// Tính tổng tiền
$tongTien = $tour['giaTour'] * $soNguoi;

// =============================================
// LƯU ĐƠN ĐẶT - TẠM KHÓA CHỖ
// =============================================
$stmtInsert = $mysqli->prepare("
    INSERT INTO dondat (maND, maTour, ngayDat, soNguoi, tongTien, phuongThucTT, trangThaiTT, thoiGianDat)
    VALUES (?, ?, ?, ?, ?, '', 'choPhanHoi', NOW())
");
$stmtInsert->bind_param("iisid", $_SESSION['maND'], $maTour, $tour['ngayKhoiHanh'], $soNguoi, $tongTien);

if ($stmtInsert->execute()) {
    $maDon = $mysqli->insert_id;

    // Trừ số chỗ trống tạm thời
    $stmtUpdate = $mysqli->prepare("
        UPDATE tour SET soChoTrong = soChoTrong - ?
        WHERE maTour = ?
    ");
    $stmtUpdate->bind_param("ii", $soNguoi, $maTour);
    $stmtUpdate->execute();

    // Nếu hết chỗ thì chuyển sang Tạm dừng
    $stmtKiemTra = $mysqli->prepare("SELECT soChoTrong FROM tour WHERE maTour = ?");
    $stmtKiemTra->bind_param("i", $maTour);
    $stmtKiemTra->execute();
    $tourMoi = $stmtKiemTra->get_result()->fetch_assoc();

    if ($tourMoi['soChoTrong'] <= 0) {
        $stmtTamDung = $mysqli->prepare("UPDATE tour SET trangThai = 'Tạm dừng' WHERE maTour = ?");
        $stmtTamDung->bind_param("i", $maTour);
        $stmtTamDung->execute();
    }

    // Chuyển sang trang thanh toán
    header('Location: ../../pages/khachHang/thanhToan.php?maDon=' . $maDon);
    exit();
} else {
    header('Location: ../../pages/khachHang/datTour.php?id=' . $maTour . '&error=loi_he_thong');
    exit();
}