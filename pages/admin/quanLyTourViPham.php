<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$search = trim($_GET['search'] ?? '');

// Lấy các tour Tạm dừng có báo cáo daXuLy, kèm lý do từ báo cáo mới nhất
$sql = "
    SELECT t.maTour, t.tenTour, t.trangThai,
           u.hoTen AS tenNPP,
           d.tenDiemDen,
           bc.noiDung AS lyDo,
           bc.ngayGui
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
                <h3 class="mb-4 text-title">Danh sách tour vi phạm</h3>

                <hr>
                <?php if (!empty($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?= match ($_GET['success']) {
                            'go_tour'     => 'Đã gỡ tour khỏi hệ thống.',
                            'khoi_phuc'   => 'Đã khôi phục tour thành công.',
                            default       => 'Thao tác thành công!'
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
                                            <a href="chiTietTour.php?maTour=<?= $t['maTour'] ?>" class="btn btn-info btn-sm">Xem</a>
                                            <a href="../../actions/tour/deleteTour.php?id=<?= $t['maTour'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Gỡ tour này khỏi hệ thống?')">Gỡ tour</a>
                                            <a href="../../actions/tour/restoreTour.php?id=<?= $t['maTour'] ?>"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Khôi phục tour này?')">Khôi phục</a>
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