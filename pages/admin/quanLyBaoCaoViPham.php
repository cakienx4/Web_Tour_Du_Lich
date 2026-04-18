<?php
session_start();
require_once '../../config/database.php';

$search   = trim($_GET['search'] ?? '');
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

$validTrangThai = ['choPhanHoi', 'daXuLy'];
if ($trangThai && in_array($trangThai, $validTrangThai)) {
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
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php include "../../includes/sideBar-admin.php"; ?>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <!-- TITLE -->
                <h3 class="mb-4 text-title">Danh sách báo cáo vi phạm</h3>

                <hr>
                <?php if (!empty($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?= match ($_GET['success']) {
                            'da_xu_ly' => 'Đã đánh dấu xử lý báo cáo.',
                            'xoa'      => 'Đã xóa báo cáo.',
                            default    => 'Thao tác thành công!'
                        } ?>
                    </div>
                <?php endif; ?>
                <!-- FILTER -->
                <div class="content-box mb-3">
                    <form method="GET" action="">
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
                                            <a href="chiTietBaoCao.php?id=<?= $bc['maBaoCao'] ?>" class="btn btn-info btn-sm">Xem</a>
                                            <?php if ($bc['trangThaiXuLy'] === 'choPhanHoi'): ?>
                                                <a href="../../actions/baoCao/handleReport.php?id=<?= $bc['maBaoCao'] ?>&action=xu_ly"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Đánh dấu đã xử lý?')">Đánh dấu xử lý</a>
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

</body>

</html>