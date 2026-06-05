<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Nhà phân phối tour') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

$maND = intval($_SESSION['maND']);

// Đánh dấu đã xem
if (isset($_GET['daXem'])) {
    $maPhanHoi = intval($_GET['daXem']);
    $stmt = $mysqli->prepare("
        UPDATE phanhoi
        SET trangThai = 'daXem'
        WHERE maPhanHoi = ? AND maND = ?
    ");
    $stmt->bind_param("ii", $maPhanHoi, $maND);
    $stmt->execute();
    header("Location: nhanPhanHoi.php");
    exit();
}

$timKiem   = trim($_GET['timKiem'] ?? '');
$trangThai = trim($_GET['trangThai'] ?? '');

$sql = "
    SELECT ph.maPhanHoi, ph.noiDung, ph.ngayGui, ph.trangThai,
           bc.maBaoCao,
           IFNULL(bc.maTour, 0) as maTour,
           t.tenTour
    FROM phanhoi ph
    LEFT JOIN baocao bc ON ph.maBaoCao = bc.maBaoCao
    LEFT JOIN tour t ON bc.maTour = t.maTour
    WHERE ph.maND = ?
";
$params = [$maND];
$types  = 'i';

if (!empty($timKiem)) {
    $sql .= " AND ph.noiDung LIKE ?";
    $params[] = "%$timKiem%";
    $types .= 's';
}

if (!empty($trangThai)) {
    $sql .= " AND ph.trangThai = ?";
    $params[] = $trangThai;
    $types .= 's';
}

$sql .= "
    ORDER BY
        (ph.trangThai = 'daXem'),
        ph.maPhanHoi DESC
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$phanHois = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phản hồi từ Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>

    <?php include "../../includes/sideBar-NPP.php"; ?>

    <div class="main-content p-4">

        <h3 class="mb-4 text-title">Phản hồi từ Quản trị viên</h3>
        <hr>

        <!-- FILTER -->
        <div class="content-box mb-3">
            <form action="nhanPhanHoi.php" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label">Nội dung</label>
                        <input type="text" name="timKiem" class="form-control"
                            placeholder="Tìm theo nội dung..."
                            value="<?= htmlspecialchars($timKiem) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái</label>
                        <select name="trangThai" class="form-select">
                            <option value="">Tất cả</option>
                            <option value="chuaXem" <?= $trangThai === 'chuaXem' ? 'selected' : '' ?>>Chưa xem</option>
                            <option value="daXem" <?= $trangThai === 'daXem'   ? 'selected' : '' ?>>Đã xem</option>
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
                        <th>Tour liên quan</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($ph = $phanHois->fetch_assoc()): ?>
                        <tr>
                            <td><?= $ph['maPhanHoi'] ?></td>

                            <td>
                                <?php if (!empty($ph['tenTour'])): ?>
                                    <a href="chiTietTour.php?maTour=<?= $ph['maTour'] ?>"
                                        class="fw-bold text-decoration-none text-primary">
                                        <?= htmlspecialchars($ph['tenTour']) ?>
                                    </a>
                                <?php else: ?>
                                    <?php if (preg_match('/"([^"]+)"/', $ph['noiDung'], $matches)): ?>
                                        <span class="text-secondary fst-italic"><?= htmlspecialchars($matches[1]) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">—</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars(mb_substr($ph['noiDung'], 0, 60)) ?>...</td>
                            <td><?= date('d/m/Y', strtotime($ph['ngayGui'])) ?></td>

                            <td>
                                <?php if ($ph['trangThai'] === 'chuaXem'): ?>
                                    <span class="badge bg-warning text-dark">Chưa xem</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Đã xem</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($ph['maBaoCao'])): ?>
                                    <!-- Phản hồi từ báo cáo vi phạm — có trang chi tiết -->
                                    <a href="chiTietPhanHoi.php?maPhanHoi=<?= $ph['maPhanHoi'] ?>"
                                        class="btn btn-info btn-sm">Xem</a>
                                <?php else: ?>
                                    <!-- Phản hồi trực tiếp từ admin (duyệt/từ chối/tạm dừng/mở bán) -->
                                    <?php if ($ph['trangThai'] === 'chuaXem'): ?>
                                        <a href="?daXem=<?= $ph['maPhanHoi'] ?>"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Đánh dấu phản hồi này là đã xem?')">
                                            Đánh dấu đã xem
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">—</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <?php if ($phanHois->num_rows === 0): ?>
                        <tr>
                            <td colspan="6" class="text-center">Không có phản hồi nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>