<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $mysqli->prepare("DELETE FROM tour WHERE maTour = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: ../../pages/admin/quanLyTour.php");
exit;