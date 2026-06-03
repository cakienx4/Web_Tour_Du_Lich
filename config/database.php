<?php
$host = "localhost:3300";
$dbname = "tavivu";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname, 3300);

if ($mysqli->connect_error) {
    die("Kết nối thất bại: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");

$mysqli->query("
    UPDATE tour
    SET trangThai = 'Đã kết thúc'
    WHERE trangThai IN ('Đang bán', 'Tạm dừng')
    AND ngayKhoiHanh < CURDATE()
");
?>