<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../../pages/admin/duyetTour.php?error=missing_id");
    exit;
}

$stmt = $mysqli->prepare("
    UPDATE tour 
    SET trangThai = 'Từ chối'
    WHERE maTour = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../../pages/admin/duyetTour.php?success=rejected");
exit;