<?php
session_start();
require_once '../../config/database.php';

// Check quyền
if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

// Tìm kiếm & lọc
$timKiem = $_GET['timKiem'] ?? '';
$trangThai = $_GET['trangThai'] ?? '';

$sql = "
SELECT 
    t.maTour, 
    t.tenTour, 
    t.giaTour, 
    t.soChoTrong, 
    t.trangThai, 
    u.hoTen,
    d.tenDiemDen
FROM tour t
JOIN user u ON t.maND = u.maND
JOIN tour_diemden td ON t.maTour = td.maTour
JOIN diemden d ON td.maDiemDen = d.maDiemDen
WHERE t.trangThai <> 'Chờ duyệt'
";

$params = [];
$types = "";

// Tìm kiếm theo tên tour
if (!empty($timKiem)) {
    $sql .= " AND t.tenTour LIKE ?";
    $params[] = "%$timKiem%";
    $types .= "s";
}

// Lọc trạng thái
if (!empty($trangThai) && $trangThai !== 'Tất cả') {
    $sql .= " AND t.trangThai = ?";
    $params[] = $trangThai;
    $types .= "s";
}

$sql .= " ORDER BY t.maTour DESC";

$stmt = $mysqli->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$tours = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>
    <!-- SIDEBAR -->
    <?php include "../../includes/sideBar-admin.php"; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content p-4">

        <!-- TITLE -->
        <h3 class="mb-4 text-title">Quản lý tour</h3>
        <hr>
        <!-- TOOLBAR -->
        <div class="content-box mb-3">
            <form method="GET">
                <div class="row">

                    <div class="col-md-6">
                        <label><strong>Tìm kiếm</strong></label>
                        <input type="text" name="timKiem" class="form-control"
                            value="<?= htmlspecialchars($timKiem) ?>">
                    </div>

                    <div class="col-md-3">
                        <label><strong>Trạng thái</strong></label>
                        <select name="trangThai" class="form-select">
                            <option>Tất cả</option>
                            <option <?= $trangThai == 'Đang bán' ? 'selected' : '' ?>>Đang bán</option>
                            <option <?= $trangThai == 'Tạm dừng' ? 'selected' : '' ?>>Tạm dừng</option>
                            <option <?= $trangThai == 'Đã kết thúc' ? 'selected' : '' ?>>Đã kết thúc</option>
                            <option <?= $trangThai == 'Từ chối' ? 'selected' : '' ?>>Từ chối</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Lọc</button>
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
                        <th>Nhà phân phối</th>
                        <th>Điểm đến</th>
                        <th>Giá</th>
                        <th>Số chỗ trống</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($tour = $tours->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?= $tour['maTour'] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($tour['tenTour']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($tour['hoTen']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($tour['tenDiemDen'] ?? 'Chưa có') ?>
                            </td>

                            <td>
                                <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ
                            </td>

                            <td>
                                <?= $tour['soChoTrong'] ?>
                            </td>

                            <td>
                                <?php if ($tour['trangThai'] === 'Đang bán'): ?>
                                    <span class="badge bg-success">Đang bán</span>
                                <?php elseif ($tour['trangThai'] === 'Tạm dừng'): ?>
                                    <span class="badge bg-warning text-dark">Tạm dừng</span>
                                <?php elseif ($tour['trangThai'] === 'Đã kết thúc'): ?>
                                    <span class="badge bg-secondary">Đã kết thúc</span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><?= $tour['trangThai'] ?></span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <!-- Xem -->
                                <a href="../admin/chiTietTour.php?maTour=<?= $tour['maTour'] ?>&from=quanLyTours"
                                    class="btn btn-info btn-sm">Xem</a>

                                <!-- Xóa -->
                                <?php if (in_array($tour['trangThai'], ['Tạm dừng', 'Từ chối'])): ?>
                                    <a href="../../actions/tour/deleteTour_admin.php?id=<?= $tour['maTour'] ?>&from=quanLyTours"
                                        class="btn btn-danger btn-sm" onclick="return confirm('Xóa tour này?')">
                                        Xóa
                                    </a>
                                <?php endif; ?>

                                <?php if (
                                    $tour['trangThai'] !== 'Đã kết thúc' &&
                                    $tour['trangThai'] !== 'Từ chối'
                                ): ?>
                                    <?php if ($tour['trangThai'] === 'Đang bán'): ?>
                                        <button type="button" class="btn btn-warning btn-sm"
                                            onclick="moModalTamDung(<?= $tour['maTour'] ?>)">
                                            Tạm dừng
                                        </button>
                                    <?php else: ?>
                                        <form action="../../actions/tour/changeStatus_admin.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $tour['maTour'] ?>">
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Mở bán lại tour này?')">
                                                Mở bán
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- MODAL TẠM DỪNG -->
    <div class="modal fade" id="modalTamDung" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../actions/tour/changeStatus_admin.php" method="POST">
                    <input type="hidden" name="id" id="tamDungId">
                    <div class="modal-header">
                        <h5 class="modal-title">Tạm dừng tour</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label"><strong>Lý do tạm dừng <span class="text-danger">*</span></strong></label>
                            <textarea name="lyDo" class="form-control" rows="4"
                                placeholder="Nhập lý do tạm dừng để thông báo cho nhà phân phối..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-warning">Xác nhận tạm dừng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function moModalTamDung(maTour) {
            document.getElementById('tamDungId').value = maTour;
            new bootstrap.Modal(document.getElementById('modalTamDung')).show();
        }
    </script>
</body>

</html>