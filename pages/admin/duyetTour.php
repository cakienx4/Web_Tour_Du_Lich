<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$search = trim($_GET['search'] ?? '');

$sql = "
    SELECT t.maTour, t.tenTour, t.giaTour, t.soChoTrong,
           u.hoTen,
           GROUP_CONCAT(d.tenDiemDen SEPARATOR ', ') AS tenDiemDen
    FROM tour t
    JOIN user u ON t.maND = u.maND
    LEFT JOIN tour_diemden td ON t.maTour = td.maTour
    LEFT JOIN diemden d ON td.maDiemDen = d.maDiemDen
    WHERE t.trangThai = 'Chờ duyệt'
";
$params = [];
$types  = '';

if ($search) {
    $sql .= " AND (t.tenTour LIKE ? OR u.hoTen LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types   .= 'ss';
}

$sql .= " GROUP BY t.maTour ORDER BY t.maTour DESC";
$stmt = $mysqli->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Duyệt tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <?php include "../../includes/sideBar-admin.php"; ?>

            <div class="col-md-9 col-lg-10 p-4" style="margin-left: 336px;">

                <h3 class="mb-4 text-title">Duyệt tour</h3>
                <hr>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= match ($_GET['success']) {
                            'approved' => 'Đã duyệt tour thành công.',
                            'rejected' => 'Đã từ chối tour.',
                            default    => 'Thao tác thành công.'
                        } ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        Có lỗi xảy ra, vui lòng thử lại.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <form method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tìm kiếm theo tên tour hoặc nhà phân phối..."
                                    value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-secondary w-100">Tìm</button>
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
                            <?php if ($result->num_rows === 0): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Không có tour nào chờ duyệt.</td>
                                </tr>
                            <?php else: ?>
                                <?php while ($tour = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $tour['maTour'] ?></td>
                                        <td><?= htmlspecialchars($tour['tenTour']) ?></td>
                                        <td><?= htmlspecialchars($tour['hoTen']) ?></td>
                                        <td><?= htmlspecialchars($tour['tenDiemDen'] ?? '—') ?></td>
                                        <td><?= number_format($tour['giaTour'], 0, ',', '.') ?>đ</td>
                                        <td><?= $tour['soChoTrong'] ?></td>
                                        <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                                        <td>
                                            <a href="chiTietTour.php?maTour=<?= $tour['maTour'] ?>"
                                                class="btn btn-info btn-sm">Xem</a>
                                            <a href="../../actions/tour/approveTour.php?id=<?= $tour['maTour'] ?>"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Duyệt tour này?')">Duyệt</a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="moModalTuChoi(<?= $tour['maTour'] ?>)">Từ chối</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL TỪ CHỐI -->
    <div class="modal fade" id="modalTuChoi" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../actions/tour/rejectTour.php" method="POST">
                    <input type="hidden" name="id" id="tuChoiId">

                    <div class="modal-header">
                        <h5 class="modal-title">Từ chối tour</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label"><strong>Lý do từ chối <span class="text-danger">*</span></strong></label>
                            <textarea name="lyDo" class="form-control" rows="4"
                                placeholder="Nhập lý do từ chối để thông báo cho nhà phân phối..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function moModalTuChoi(maTour) {
            document.getElementById('tuChoiId').value = maTour;
            new bootstrap.Modal(document.getElementById('modalTuChoi')).show();
        }
    </script>
</body>

</html>