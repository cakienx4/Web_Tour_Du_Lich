<?php
session_start();
require_once '../../config/database.php';

$diemDenList = $mysqli->query("
    SELECT maDiemDen, tenDiemDen, moTa, anhDiemDen, vungMien 
    FROM diemden 
    ORDER BY vungMien, tenDiemDen
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <title>Danh sách điểm đến</title>
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
                        <a href="trangChu.php" class="breadcrumb-link">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item active">Danh sách điểm đến</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container my-4">
        <h1 class="page-title">Danh sách điểm đến</h1>
        <hr>
        <?php
        $vungHienTai = '';
        while ($dd = $diemDenList->fetch_assoc()):
            if ($dd['vungMien'] !== $vungHienTai):
                if ($vungHienTai !== '')
                    echo '</div>'; // đóng destination-list trước
                $vungHienTai = $dd['vungMien'];
                ?>
                <h3 class="mt-4 mb-3">Miền
                    <?= htmlspecialchars($dd['vungMien']) ?>
                </h3>
                <div class="destination-list">
                <?php endif; ?>

                <a href="tour.php?diemDen=<?= $dd['maDiemDen'] ?>" class="destination-card">
                    <div class="destination-image">
                        <img src="../../<?= htmlspecialchars($dd['anhDiemDen'] ?? '') ?>"
                            alt="<?= htmlspecialchars($dd['tenDiemDen']) ?>">
                    </div>
                    <div class="destination-content">
                        <h3 class="destination-name">
                            <?= htmlspecialchars($dd['tenDiemDen']) ?>
                        </h3>
                        <p class="destination-desc">
                            <?= htmlspecialchars($dd['moTa']) ?>
                        </p>
                    </div>
                </a>

            <?php endwhile; ?>
            <?php if ($vungHienTai !== '')
                echo '</div>'; // đóng destination-list cuối ?>
        </div>
        <?php include '../../includes/footer.php'; ?>
</body>

</html>