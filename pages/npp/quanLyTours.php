<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maND = intval($_SESSION['maND']);

$timKiem  = trim($_GET['timKiem'] ?? '');
$trangThai = trim($_GET['trangThai'] ?? '');

$sql = "
    SELECT t.maTour, t.tenTour, t.giaTour, t.ngayKhoiHanh, t.soChoTrong, t.tongSoCho, t.trangThai,
           GROUP_CONCAT(d.tenDiemDen SEPARATOR ', ') AS danhSachDiemDen
    FROM tour t
    LEFT JOIN tour_diemden td ON t.maTour = td.maTour
    LEFT JOIN diemden d ON td.maDiemDen = d.maDiemDen
    WHERE t.maND = ?
";
$params = [$maND];
$types  = 'i';

if (!empty($timKiem)) {
    $sql .= " AND t.tenTour LIKE ?";
    $params[] = "%$timKiem%";
    $types .= 's';
}

if (!empty($trangThai)) {
    $sql .= " AND t.trangThai = ?";
    $params[] = $trangThai;
    $types .= 's';
}

$sql .= " GROUP BY t.maTour ORDER BY t.maTour DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$tours = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tour đã tạo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>

    <!-- SIDEBAR -->
    <?php include "../../includes/sideBar-NPP.php"; ?>

    <!-- CONTENT -->
    <div class="main-content p-4">

        <h3 class="mb-4 text-title">Danh sách tour đã tạo</h3>
        <hr>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php
                echo match ($_GET['success']) {
                    'created'  => 'Tạo tour thành công. Tour đang chờ admin duyệt.',
                    'updated'  => 'Cập nhật tour thành công.',
                    'deleted'  => 'Xóa tour thành công.',
                    default    => 'Thao tác thành công.',
                };
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php
                echo match ($_GET['error']) {
                    'cannot_delete' => 'Không thể xóa tour đang có đơn đặt.',
                    default         => 'Có lỗi xảy ra, vui lòng thử lại.',
                };
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- FILTER -->
        <div class="content-box mb-3">
            <form action="quanLyTours.php" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" name="timKiem" class="form-control"
                            placeholder="Tên tour..."
                            value="<?= htmlspecialchars($timKiem) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái</label>
                        <select name="trangThai" class="form-select">
                            <option value="">Tất cả</option>
                            <option value="Chờ duyệt" <?= $trangThai === 'Chờ duyệt'  ? 'selected' : '' ?>>Chờ duyệt</option>
                            <option value="Đang bán" <?= $trangThai === 'Đang bán'   ? 'selected' : '' ?>>Đang bán</option>
                            <option value="Tạm dừng" <?= $trangThai === 'Tạm dừng'   ? 'selected' : '' ?>>Tạm dừng</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Tìm</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TABLE -->
        <div class="content-box">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên tour</th>
                        <th>Điểm đến</th>
                        <th>Giá</th>
                        <th>Ngày khởi hành</th>
                        <th>Chỗ còn</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($tour = $tours->fetch_assoc()): ?>
                        <tr>
                            <td><?= $tour['maTour'] ?></td>
                            <td><?= htmlspecialchars($tour['tenTour']) ?></td>
                            <td><?= htmlspecialchars($tour['danhSachDiemDen'] ?? 'Chưa có') ?></td>
                            <td><?= number_format($tour['giaTour'], 0, ',', '.') ?>đ</td>
                            <td><?= date('d/m/Y', strtotime($tour['ngayKhoiHanh'])) ?></td>
                            <td><?= $tour['soChoTrong'] ?>/<?= $tour['tongSoCho'] ?></td>
                            <td>
                                <?php if ($tour['trangThai'] === 'Chờ duyệt'): ?>
                                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                <?php elseif ($tour['trangThai'] === 'Đang bán'): ?>
                                    <span class="badge bg-success">Đang bán</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tạm dừng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="chiTietTour.php?maTour=<?= $tour['maTour'] ?>"
                                    class="btn btn-info btn-sm">Xem</a>

                                <?php if ($tour['trangThai'] === 'Chờ duyệt'): ?>
                                    <a href="../../actions/tour/deleteTour.php?maTour=<?= $tour['maTour'] ?>"
                                        class="btn btn-secondary btn-sm"
                                        onclick="return confirm('Hủy tour này?')">Hủy</a>

                                <?php elseif ($tour['trangThai'] === 'Đang bán'): ?>
                                    <a href="../../actions/tour/changeStatus_npp.php?maTour=<?= $tour['maTour'] ?>"
                                        class="btn btn-warning btn-sm"
                                        onclick="return confirm('Tạm dừng bán tour này?')">Tạm dừng</a>

                                <?php elseif ($tour['trangThai'] === 'Tạm dừng'): ?>
                                    <a href="../../actions/tour/changeStatus_npp.php?maTour=<?= $tour['maTour'] ?>"
                                        class="btn btn-success btn-sm"
                                        onclick="return confirm('Mở bán lại tour này?')">Mở bán</a>
                                    <a href="../../actions/tour/deleteTour.php?maTour=<?= $tour['maTour'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Xóa tour này?')">Xóa</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <?php if ($tours->num_rows === 0): ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có tour nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>