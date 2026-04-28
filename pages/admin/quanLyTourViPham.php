<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$search = trim($_GET['search'] ?? '');

$sql = "
    SELECT t.maTour, t.tenTour, t.trangThai,
           u.hoTen AS tenNPP,
           d.tenDiemDen,
           bc.maBaoCao, bc.noiDung AS lyDo, bc.ngayGui
    FROM tour t
    JOIN user u ON t.maND = u.maND
    JOIN tour_diemden td ON t.maTour = td.maTour
    JOIN diemden d ON td.maDiemDen = d.maDiemDen
    JOIN baocao bc ON bc.maTour = t.maTour
    WHERE t.trangThai = 'Tạm dừng'
      AND bc.trangThaiXuLy = 'daXuLy'
      AND bc.ngayGui = (
          SELECT MAX(bc2.ngayGui) FROM baocao bc2
          WHERE bc2.maTour = t.maTour AND bc2.trangThaiXuLy = 'daXuLy'
      )
";

$params = [];
$types  = '';

if ($search) {
    $sql .= " AND (t.tenTour LIKE ? OR u.hoTen LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types   .= 'ss';
}

$sql .= " ORDER BY bc.ngayGui DESC";
$stmt = $mysqli->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$dsTourViPham = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách tour vi phạm</title>
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

                <h3 class="mb-4 text-title">Danh sách tour vi phạm</h3>
                <hr>

                <?php if (!empty($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= match($_GET['success']) {
                            'go_tour'   => 'Đã gỡ tour khỏi hệ thống.',
                            'khoi_phuc' => 'Đã khôi phục tour thành công.',
                            default     => 'Thao tác thành công.'
                        } ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <form method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Tìm kiếm</label>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Tên tour hoặc nhà phân phối..."
                                    value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-secondary w-100">Lọc</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABLE -->
                <div class="content-box">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Tour</th>
                                <th>Tên tour</th>
                                <th>Điểm đến</th>
                                <th>Nhà phân phối</th>
                                <th>Lý do vi phạm</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($dsTourViPham)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Không có tour vi phạm nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($dsTourViPham as $t): ?>
                                    <tr>
                                        <td><?= $t['maTour'] ?></td>
                                        <td><?= htmlspecialchars($t['tenTour']) ?></td>
                                        <td><?= htmlspecialchars($t['tenDiemDen']) ?></td>
                                        <td><?= htmlspecialchars($t['tenNPP']) ?></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($t['lyDo'], 0, 60, '...')) ?></td>
                                        <td><span class="badge bg-danger">Tạm dừng</span></td>
                                        <td>
                                            <a href="chiTietTour.php?maTour=<?= $t['maTour'] ?>"
                                                class="btn btn-info btn-sm">Xem</a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="moModalGoTour(<?= $t['maTour'] ?>, <?= $t['maBaoCao'] ?>)">
                                                Gỡ tour</button>
                                            <button type="button" class="btn btn-success btn-sm"
                                                onclick="moModalKhoiPhuc(<?= $t['maTour'] ?>, <?= $t['maBaoCao'] ?>)">
                                                Khôi phục</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL GỠ TOUR -->
    <div class="modal fade" id="modalGoTour" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../actions/tour/deleteTour_admin.php" method="POST">
                    <input type="hidden" name="id" id="goTourId">
                    <input type="hidden" name="maBaoCao" id="goTourMaBaoCao">

                    <div class="modal-header">
                        <h5 class="modal-title">Gỡ tour khỏi hệ thống</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Tour sẽ bị xóa vĩnh viễn khỏi hệ thống.</p>
                        <div class="mb-3">
                            <label class="form-label"><strong>Phản hồi gửi cho nhà phân phối</strong></label>
                            <textarea name="noiDungPhanHoi" class="form-control" rows="4"
                                placeholder="Nhập lý do gỡ tour để thông báo cho nhà phân phối..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xác nhận gỡ tour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL KHÔI PHỤC TOUR -->
    <div class="modal fade" id="modalKhoiPhuc" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../actions/tour/restoreTour.php" method="POST">
                    <input type="hidden" name="id" id="khoiPhucId">
                    <input type="hidden" name="maBaoCao" id="khoiPhucMaBaoCao">

                    <div class="modal-header">
                        <h5 class="modal-title">Khôi phục tour</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Tour sẽ được chuyển về trạng thái <strong>Đang bán</strong>.</p>
                        <div class="mb-3">
                            <label class="form-label"><strong>Phản hồi gửi cho nhà phân phối</strong></label>
                            <textarea name="noiDungPhanHoi" class="form-control" rows="4"
                                placeholder="Nhập lý do khôi phục để thông báo cho nhà phân phối..."></textarea>
                            <div class="form-text">Không bắt buộc.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Xác nhận khôi phục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function moModalGoTour(maTour, maBaoCao) {
            document.getElementById('goTourId').value = maTour;
            document.getElementById('goTourMaBaoCao').value = maBaoCao;
            new bootstrap.Modal(document.getElementById('modalGoTour')).show();
        }

        function moModalKhoiPhuc(maTour, maBaoCao) {
            document.getElementById('khoiPhucId').value = maTour;
            document.getElementById('khoiPhucMaBaoCao').value = maBaoCao;
            new bootstrap.Modal(document.getElementById('modalKhoiPhuc')).show();
        }
    </script>
</body>

</html>