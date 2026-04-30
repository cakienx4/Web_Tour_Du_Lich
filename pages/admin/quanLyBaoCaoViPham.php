<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$search    = trim($_GET['search'] ?? '');
$trangThai = $_GET['trangThai'] ?? '';

$sql = "SELECT bc.maBaoCao, u.hoTen, t.tenTour, bc.noiDung, bc.ngayGui, bc.trangThaiXuLy
        FROM baocao bc
        JOIN user u ON bc.maND = u.maND
        JOIN tour t ON bc.maTour = t.maTour
        WHERE 1=1";
$params = [];
$types  = '';

if ($search) {
    $sql .= " AND (u.hoTen LIKE ? OR bc.noiDung LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types   .= 'ss';
}

if ($trangThai && in_array($trangThai, ['choPhanHoi', 'daXuLy'])) {
    $sql .= " AND bc.trangThaiXuLy = ?";
    $params[] = $trangThai;
    $types   .= 's';
}

$sql .= " ORDER BY bc.ngayGui DESC";
$stmt = $mysqli->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$dsBaoCao = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo cáo vi phạm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <?php include "../../includes/sideBar-admin.php"; ?>

    <div class="main-content p-4">

        <h3 class="mb-4 text-title">Danh sách báo cáo vi phạm</h3>
        <hr>

        <?php if (!empty($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= match ($_GET['success']) {
                    'da_xu_ly' => 'Đã xử lý báo cáo và gửi phản hồi cho nhà phân phối.',
                    'xoa'      => 'Đã xóa báo cáo.',
                    default    => 'Thao tác thành công.'
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
                            placeholder="Người gửi hoặc nội dung..."
                            value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái xử lý</label>
                        <select name="trangThai" class="form-select">
                            <option value="">Tất cả</option>
                            <option value="choPhanHoi" <?= $trangThai === 'choPhanHoi' ? 'selected' : '' ?>>Chờ xử lý</option>
                            <option value="daXuLy" <?= $trangThai === 'daXuLy'     ? 'selected' : '' ?>>Đã xử lý</option>
                        </select>
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
                        <th>ID</th>
                        <th>Người gửi</th>
                        <th>Tour</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dsBaoCao)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Không có báo cáo nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dsBaoCao as $bc): ?>
                            <tr>
                                <td><?= $bc['maBaoCao'] ?></td>
                                <td><?= htmlspecialchars($bc['hoTen']) ?></td>
                                <td><?= htmlspecialchars($bc['tenTour']) ?></td>
                                <td><?= htmlspecialchars(mb_strimwidth($bc['noiDung'], 0, 50, '...')) ?></td>
                                <td><?= date('d/m/Y', strtotime($bc['ngayGui'])) ?></td>
                                <td>
                                    <?php if ($bc['trangThaiXuLy'] === 'choPhanHoi'): ?>
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Đã xử lý</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="chiTietBaoCao.php?id=<?= $bc['maBaoCao'] ?>"
                                        class="btn btn-info btn-sm">Xem</a>

                                    <?php if ($bc['trangThaiXuLy'] === 'choPhanHoi'): ?>
                                        <button type="button" class="btn btn-success btn-sm"
                                            onclick="moModalXuLy(<?= $bc['maBaoCao'] ?>)">
                                            Đánh dấu xử lý
                                        </button>
                                    <?php endif; ?>

                                    <a href="../../actions/baoCao/handleReport.php?id=<?= $bc['maBaoCao'] ?>&action=xoa"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Xóa báo cáo này?')">Xóa</a>
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

    <!-- MODAL XỬ LÝ BÁO CÁO -->
    <div class="modal fade" id="modalXuLy" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../../actions/baoCao/handleReport.php" method="POST">
                    <input type="hidden" name="action" value="xu_ly">
                    <input type="hidden" name="id" id="modalMaBaoCao">

                    <div class="modal-header">
                        <h5 class="modal-title">Xử lý báo cáo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Tour liên quan sẽ bị chuyển sang <strong>Tạm dừng</strong>.</p>
                        <div class="mb-3">
                            <label class="form-label"><strong>Phản hồi gửi cho nhà phân phối</strong></label>
                            <textarea name="noiDungPhanHoi" class="form-control" rows="4"
                                placeholder="Nhập lý do xử lý để thông báo cho nhà phân phối..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Xác nhận xử lý</button>
                    </div>
                </form>
            </div>

            <script>
                function moModalXuLy(maBaoCao) {
                    document.getElementById('modalMaBaoCao').value = maBaoCao;
                    new bootstrap.Modal(document.getElementById('modalXuLy')).show();
                }
            </script>
</body>

</html>