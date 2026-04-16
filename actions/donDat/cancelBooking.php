<?php
session_start();
require_once '../../config/database.php';

$error = "";
$success = "";

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['maND'])) {
    header("Location: ../../pages/auth/dangNhap.php");
    exit();
}

// 2. Kiểm tra mã đơn
if (!isset($_GET['maDon'])) {
    $error = "Thiếu mã đơn";
}

// 3. Xử lý khi không có lỗi ban đầu
if ($error === "") {

    $maDon = (int) $_GET['maDon'];
    $maND = $_SESSION['maND'];

    // 4. Lấy thông tin đơn
    $stmt = $mysqli->prepare("
        SELECT * FROM dondat 
        WHERE maDon = ? AND maND = ?
    ");
    $stmt->bind_param("ii", $maDon, $maND);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $error = "Đơn không tồn tại hoặc không thuộc về bạn";
    } else {
        $don = $result->fetch_assoc();

        // 5. Kiểm tra trạng thái
        if ($don['trangThaiTT'] === 'daHuy') {
            $error = "Đơn đã được hủy trước đó";
        }
    }
}

// 6. Nếu không lỗi → xử lý DB
if ($error === "") {

    $mysqli->begin_transaction();

    // Update đơn
    $stmt1 = $mysqli->prepare("
        UPDATE dondat 
        SET trangThaiTT = 'daHuy' 
        WHERE maDon = ?
    ");
    $stmt1->bind_param("i", $maDon);

    // Update số chỗ
    $stmt2 = $mysqli->prepare("
        UPDATE tour 
        SET soChoTrong = soChoTrong + ? 
        WHERE maTour = ?
    ");
    $stmt2->bind_param("ii", $don['soNguoi'], $don['maTour']);

    // Update trạng thái tour
    $stmt3 = $mysqli->prepare("
        UPDATE tour 
        SET trangThai = 'Đang bán'
        WHERE maTour = ? AND trangThai = 'Tạm dừng'
    ");
    $stmt3->bind_param("i", $don['maTour']);

    // Thực thi
    if (
        $stmt1->execute() &&
        $stmt2->execute() &&
        $stmt3->execute()
    ) {
        $mysqli->commit();
        $success = "Hủy đơn thành công";
    } else {
        $mysqli->rollback();
        $error = "Có lỗi xảy ra khi hủy đơn";
    }
}

// 7. Xử lý hiển thị / redirect
if ($error !== "") {
    // cách 1: truyền lỗi qua session
    $_SESSION['error'] = $error;
} else {
    $_SESSION['success'] = $success;
}

header("Location: ../../pages/khachHang/lichSuDatTour.php");
exit();