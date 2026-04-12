<?php
session_start();
require_once '../../config/database.php';

// Nhận tham số filter từ GET
$vung = $_GET['vung'] ?? '';
$diemDen = $_GET['diemDen'] ?? '';
$giaMin = null;
$giaMax = null;
$ngayMin = null;
$ngayMax = null;

// Xử lý filter giá
if (!empty($_GET['gia'])) {
    switch ($_GET['gia']) {
        case 'duoi10tr':
            $giaMax = 10000000;
            break;
        case 'tu10den20':
            $giaMin = 10000000;
            $giaMax = 20000000;
            break;
        case 'tu20den40':
            $giaMin = 20000000;
            $giaMax = 40000000;
            break;
        case 'tren40tr':
            $giaMin = 40000000;
            break;
    }
}

// Xử lý filter thời gian
if (!empty($_GET['thoigian'])) {
    switch ($_GET['thoigian']) {
        case '1den2ngay':
            $ngayMin = 1;
            $ngayMax = 2;
            break;
        case '3den4ngay':
            $ngayMin = 3;
            $ngayMax = 4;
            break;
        case '5den7ngay':
            $ngayMin = 5;
            $ngayMax = 7;
            break;
    }
}

// Build query động
$sql = "
    SELECT DISTINCT t.maTour, t.tenTour, t.giaTour, t.ngayKhoiHanh, t.soNgay,
           (SELECT duongDan FROM tour_anh WHERE maTour = t.maTour AND laManhChinh = 1 LIMIT 1) AS anhTour
    FROM tour t
    JOIN tour_diemden td ON t.maTour = td.maTour
    JOIN diemden d ON td.maDiemDen = d.maDiemDen
    WHERE t.trangThai = 'Đang bán'
";

$params = [];
$types = '';

if (!empty($vung)) {
    $sql .= " AND d.vungMien = ?";
    $params[] = $vung;
    $types .= 's';
}

if (!empty($diemDen)) {
    $sql .= " AND d.maDiemDen = ?";
    $params[] = $diemDen;
    $types .= 'i';
}

if ($giaMin !== null) {
    $sql .= " AND t.giaTour >= ?";
    $params[] = $giaMin;
    $types .= 'd';
}

if ($giaMax !== null) {
    $sql .= " AND t.giaTour <= ?";
    $params[] = $giaMax;
    $types .= 'd';
}

if ($ngayMin !== null) {
    $sql .= " AND t.soNgay >= ?";
    $params[] = $ngayMin;
    $types .= 'i';
}

if ($ngayMax !== null) {
    $sql .= " AND t.soNgay <= ?";
    $params[] = $ngayMax;
    $types .= 'i';
}

$sql .= " ORDER BY t.maTour DESC";

$stmt = $mysqli->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$tours = $stmt->get_result();

// Lấy điểm đến cho filter sidebar
$diemDenList = $mysqli->query("SELECT maDiemDen, tenDiemDen FROM diemden ORDER BY tenDiemDen");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/khachHang.css">

</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <!-- ------------------------------------- BREADCRUMB ------------------------------------- -->

    <div class="breadcrumb-box">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb tour-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="trangChu.php" class="breadcrumb-link ">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="tour.php" class="breadcrumb-link">Danh sách tour</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>


    <!-- ------------------------------------- SIDEBAR ------------------------------------- -->

    <div class="container my-4">
        <div class="row">
            <!-- SIDEBAR FILTER -->
            <div class="col-lg-3 col-md-4">
                <form action="tour.php" method="GET">
                    <div class="filter-sidebar">

                        <h5 class="filter-title">Bộ lọc tìm kiếm</h5>

                        <!-- Miền -->
                        <div class="filter-group">
                            <h6 class="filter-heading">Miền</h6>

                            <div class="filter-options">
                                <input type="radio" name="vung" id="bac" value="Bắc" class="filter-checkbox"
                                    <?= ($_GET['vung'] ?? '') === 'Bắc' ? 'checked' : '' ?>>
                                <label for="bac" class="filter-box">Bắc</label>

                                <input type="radio" name="vung" id="trung" value="Trung" class="filter-checkbox"
                                    <?= ($_GET['vung'] ?? '') === 'Trung' ? 'checked' : '' ?>>
                                <label for="trung" class="filter-box">Trung</label>

                                <input type="radio" name="vung" id="nam" value="Nam" class="filter-checkbox"
                                    <?= ($_GET['vung'] ?? '') === 'Nam' ? 'checked' : '' ?>>
                                <label for="nam" class="filter-box">Nam</label>
                            </div>
                        </div>

                        <!-- Điểm đến -->
                        <div class="filter-group">
                            <h6 class="filter-heading">Điểm đến</h6>

                            <div class="filter-options">

                                <?php while ($dd = $diemDenList->fetch_assoc()): ?>
                                    <input type="radio" name="diemDen" id="dd_<?= $dd['maDiemDen'] ?>"
                                        value="<?= $dd['maDiemDen'] ?>" class="filter-checkbox" <?= ($_GET['diemDen'] ?? '') == $dd['maDiemDen'] ? 'checked' : '' ?>>
                                    <label for="dd_<?= $dd['maDiemDen'] ?>" class="filter-box">
                                        <?= htmlspecialchars($dd['tenDiemDen']) ?>
                                    </label>
                                <?php endwhile; ?>

                            </div>
                        </div>

                        <!-- Khoảng giá -->
                        <div class="filter-group">
                            <h6 class="filter-heading">Giá tour/khách</h6>

                            <div class="filter-options">

                                <input type="radio" name="gia" id="duoi10tr" value="duoi10tr" class="filter-checkbox"
                                    <?= ($_GET['gia'] ?? '') === 'duoi10tr' ? 'checked' : '' ?>>
                                <label for="duoi10tr" class="filter-box">Dưới 10 triệu</label>

                                <input type="radio" name="gia" id="tu10den20" value="tu10den20" class="filter-checkbox"
                                    <?= ($_GET['gia'] ?? '') === 'tu10den20' ? 'checked' : '' ?>>
                                <label for="tu10den20" class="filter-box">Từ 10-20 triệu</label>

                                <input type="radio" name="gia" id="tu20den40" value="tu20den40" class="filter-checkbox"
                                    <?= ($_GET['gia'] ?? '') === 'tu20den40' ? 'checked' : '' ?>>
                                <label for="tu20den40" class="filter-box">Từ 20-40 triệu</label>

                                <input type="radio" name="gia" id="tren40tr" value="tren40tr" class="filter-checkbox"
                                    <?= ($_GET['gia'] ?? '') === 'tren40tr' ? 'checked' : '' ?>>
                                <label for="tren40tr" class="filter-box">Trên 40 triệu</label>

                            </div>
                        </div>

                        <!-- Thời gian -->
                        <div class="filter-group">
                            <h6 class="filter-heading">Thời gian</h6>

                            <div class="filter-options">
                                <input type="radio" name="thoigian" id="1den2ngay" value="1den2ngay"
                                    class="filter-checkbox" <?= ($_GET['thoigian'] ?? '') === '1den2ngay' ? 'checked' : '' ?>>
                                <label for="1den2ngay" class="filter-box">1-2 ngày</label>

                                <input type="radio" name="thoigian" id="3den4ngay" value="3den4ngay"
                                    class="filter-checkbox" <?= ($_GET['thoigian'] ?? '') === '3den4ngay' ? 'checked' : '' ?>>
                                <label for="3den4ngay" class="filter-box">3-4 ngày</label>

                                <input type="radio" name="thoigian" id="5den7ngay" value="5den7ngay"
                                    class="filter-checkbox" <?= ($_GET['thoigian'] ?? '') === '5den7ngay' ? 'checked' : '' ?>>
                                <label for="5den7ngay" class="filter-box">5-7 ngày</label>
                            </div>

                            <!-- Button -->
                            <a href="tour.php" class="btn btn-danger w-100 mt-3">
                                Xóa bộ lọc
                            </a>
                            <button class="btn btn-primary w-100 mt-2">
                                Áp dụng bộ lọc
                            </button>

                        </div>
                    </div>
                </form>
            </div>

            <!-- ------------------------------------- DANH SÁCH TOUR (bên phải) ------------------------------------- -->

            <div class="col-lg-9">
                <div class="tour-list">
                    <?php while ($tour = $tours->fetch_assoc()): ?>
                        <a href="tour_ChiTiet.php?id=<?= $tour['maTour'] ?>" class="destination-item">
                            <div class="card-image">
                                <img src="../../<?= htmlspecialchars($tour['anhTour']) ?>"
                                    alt="<?= htmlspecialchars($tour['tenTour']) ?>">
                            </div>
                            <div class="card-content">
                                <h3>
                                    <?= htmlspecialchars($tour['tenTour']) ?>
                                </h3>
                                <p class="duration">
                                    <?= $tour['soNgay'] ?> ngày
                                    <?= $tour['soNgay'] - 1 ?> đêm
                                </p>
                                <p class="duration">Khởi hành:
                                    <?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?>
                                </p>
                                <p class="price">Từ
                                    <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ
                                </p>
                            </div>
                        </a>
                    <?php endwhile; ?>

                    <?php if ($tours->num_rows === 0): ?>
                        <p>Không tìm thấy tour nào phù hợp.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
</body>

</html>