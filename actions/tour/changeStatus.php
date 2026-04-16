<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

$stmt = $mysqli->prepare("
    UPDATE tour
    SET trangThai =
        CASE 
            WHEN trangThai = 'Đang bán' THEN 'Tạm dừng'
            WHEN trangThai = 'Tạm dừng' THEN 'Đang bán'
            ELSE trangThai
        END
    WHERE maTour = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../../pages/admin/quanLyTours.php");
exit;