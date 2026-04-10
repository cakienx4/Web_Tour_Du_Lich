<?php
session_start();
require_once '../../config/database.php';

// Lấy tour theo từng vùng miền (chỉ lấy tour đang hoạt động)
function getTourByVung($mysqli, $vung, $limit = 4)
{
    $stmt = $mysqli->prepare("
        SELECT t.maTour, t.tenTour, t.giaTour, t.ngayKhoiHanh, t.soChoTrong, t.anhTour
        FROM tour t
        JOIN tour_diemden td ON t.maTour = td.maTour
        JOIN diemden d ON td.maDiemDen = d.maDiemDen
        WHERE d.vungMien = ? AND t.trangThai = 'Đang bán'
        GROUP BY t.maTour
        LIMIT ?
    ");
    $stmt->bind_param("si", $vung, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

$tourBac = getTourByVung($mysqli, 'Bắc');
$tourTrung = getTourByVung($mysqli, 'Trung');
$tourNam = getTourByVung($mysqli, 'Nam');

// Lấy danh sách điểm đến cho dropdown tìm kiếm
$diemDenList = $mysqli->query("SELECT maDiemDen, tenDiemDen FROM diemden ORDER BY vungMien");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/khachHang.css">
</head>

<body>

    <?php include '../../includes/header.php'; ?>

    <!-- ------------------------------------- BANNER - THANH TÌM KIẾM ------------------------------------- -->

    <section class="hero">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>Khám phá Tour Du Lịch Việt Nam</h1>
                <p>Muôn vàn tour trong nước – Giá tốt – Khởi hành mỗi ngày</p>

                <form class="search-box" action="tour.php" method="GET">
                    <select name="diemDen">
                        <option value="">Chọn điểm đến</option>
                        <?php while ($dd = $diemDenList->fetch_assoc()): ?>
                            <option value="<?= $dd['maDiemDen'] ?>">
                                <?= htmlspecialchars($dd['tenDiemDen']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <input type="date">

                    <select>
                        <option>Số ngày</option>
                        <option>1 – 3 ngày</option>
                        <option>4 – 7 ngày</option>
                        <option>Trên 7 ngày</option>
                    </select>

                    <button type="submit">Tìm tour</button>
                </form>
            </div>
        </div>
    </section>

    <!-- ------------------------------------- WHY CHOOSE US ------------------------------------- -->

    <section class="why-choose-us">
        <h2 class="section-title">TAVIVU - Đại lí du lịch hàng đầu!</h2>

        <div class="reason-grid">
            <div class="reason-card">
                <h3>Tour chất lượng</h3>
                <p>Lịch trình tối ưu, điểm đến hấp dẫn, trải nghiệm thực tế.</p>
            </div>

            <div class="reason-card">
                <h3>Giá cả minh bạch</h3>
                <p>Không phí ẩn, giá tốt nhất.</p>
            </div>

            <div class="reason-card">
                <h3>Hỗ trợ 24/7</h3>
                <p>Đội ngũ tư vấn luôn sẵn sàng hỗ trợ mọi lúc.</p>
            </div>

            <div class="reason-card">
                <h3>Thanh toán an toàn</h3>
                <p>Hỗ trợ VNPay, MoMo, bảo mật thông tin tuyệt đối.</p>
            </div>
        </div>
    </section>

    <!-- ------------------------------------- DANH SÁCH TOUR NỔI BẬT ------------------------------------- -->

    <section class="destinations">
        <div class="container-fluid p-0">
            <!-- MIỀN BẮC -->
            <div class="region" style="background-color: #FFF3E0;">
                <h2>Tour Miền Bắc</h2>

                <div class="destination-list">
                    <?php while ($tour = $tourBac->fetch_assoc()): ?>
                        <a href="tour_ChiTiet.php?id=<?= $tour['maTour'] ?>" class="destination-item">
                            <div class="card-image">
                                <img src="../../<?= htmlspecialchars($tour['anhTour']) ?>"
                                    alt="<?= htmlspecialchars($tour['tenTour']) ?>">
                            </div>
                            <div class="card-content">
                                <h3><?= htmlspecialchars($tour['tenTour']) ?></h3>
                                <p class="duration">Khởi hành: <?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?></p>
                                <p class="price">Từ <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ</p>
                            </div>
                        </a>
                    <?php endwhile; ?>

                    <?php if ($tourBac->num_rows === 0): ?>
                        <p>Chưa có tour nào.</p>
                    <?php endif; ?>
                </div>

                <div class="view-more">
                    <a href="tour.php?vung=Bắc">Xem thêm tour</a>
                </div>
            </div>

            <!-- MIỀN TRUNG -->
            <div class="region" style="background-color:#EBF0F2;">
                <h2>Tour Miền Trung</h2>

                <div class="destination-list">
                    <?php while ($tour = $tourTrung->fetch_assoc()): ?>
                        <a href="tour_ChiTiet.php?id=<?= $tour['maTour'] ?>" class="destination-item">
                            <div class="card-image">
                                <img src="../../<?= htmlspecialchars($tour['anhTour']) ?>"
                                    alt="<?= htmlspecialchars($tour['tenTour']) ?>">
                            </div>
                            <div class="card-content">
                                <h3>
                                    <?= htmlspecialchars($tour['tenTour']) ?>
                                </h3>
                                <p class="duration">Khởi hành:
                                    <?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?>
                                </p>
                                <p class="price">Từ
                                    <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ
                                </p>
                            </div>
                        </a>
                    <?php endwhile; ?>

                    <?php if ($tourTrung->num_rows === 0): ?>
                        <a href="tour.php?vung=Trung">Xem thêm tour</a>
                    <?php endif; ?>
                </div>

                <div class="view-more">
                    <a href="#">Xem thêm tour</a>
                </div>
            </div>

            <!-- MIỀN NAM -->
            <div class="region" style="background-color:#FFF3E0;">
                <h2>Tour Miền Nam</h2>

                <div class="destination-list">
                    <?php while ($tour = $tourNam->fetch_assoc()): ?>
                        <a href="tour_ChiTiet.php?id=<?= $tour['maTour'] ?>" class="destination-item">
                            <div class="card-image">
                                <img src="../../<?= htmlspecialchars($tour['anhTour']) ?>"
                                    alt="<?= htmlspecialchars($tour['tenTour']) ?>">
                            </div>
                            <div class="card-content">
                                <h3>
                                    <?= htmlspecialchars($tour['tenTour']) ?>
                                </h3>
                                <p class="duration">Khởi hành:
                                    <?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?>
                                </p>
                                <p class="price">Từ
                                    <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ
                                </p>
                            </div>
                        </a>
                    <?php endwhile; ?>

                    <?php if ($tourNam->num_rows === 0): ?>
                        <p>Chưa có tour nào.</p>
                    <?php endif; ?>
                </div>

                <div class="view-more">
                    <a href="tour.php?vung=Nam">Xem thêm tour</a>
                </div>
            </div>

        </div>
    </section>

    <!-- ------------------------------------- FOOTER ------------------------------------- -->
    <?php include '../../includes/footer.php'; ?>

</body>

</html>