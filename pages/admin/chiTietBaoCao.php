<?php
session_start();
require_once '../../config/database.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: quanLyBaoCaoViPham.php');
    exit();
}

// Lấy thông tin báo cáo
$stmt = $mysqli->prepare("
    SELECT bc.*, u.hoTen AS tenNguoiGui, u.email, t.tenTour, t.maTour
    FROM baocao bc
    JOIN user u ON bc.maND = u.maND
    JOIN tour t ON bc.maTour = t.maTour
    WHERE bc.maBaoCao = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$bc = $stmt->get_result()->fetch_assoc();

if (!$bc) {
    header('Location: quanLyBaoCaoViPham.php');
    exit();
}

// Lấy danh sách phản hồi của báo cáo này
$stmt = $mysqli->prepare("
    SELECT ph.*, u.hoTen AS tenNguoiGui
    FROM phanhoi ph
    JOIN user u ON ph.maND = u.maND
    WHERE ph.maBaoCao = ?
    ORDER BY ph.ngayGui ASC
");
$stmt->bind_param("i", $id);
$stmt->execute();
$dsPhanHoi = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết báo cáo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "../../includes/sideBar-admin.php"; ?>

            <div class="col-md-9 col-lg-10 p-4">
                <h3 class="mb-4 text-title">Chi tiết báo cáo #<?= $bc['maBaoCao'] ?></h3>
                <hr>

                <?php if (!empty($_GET['success'])): ?>
                    <div class="alert alert-success">Đã gửi phản hồi thành công!</div>
                <?php endif; ?>

                <!-- THÔNG TIN BÁO CÁO -->
                <div class="content-box mb-4">
                    <h5 class="mb-3">Thông tin báo cáo</h5>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Người gửi:</div>
                        <div class="col-md-9"><?= htmlspecialchars($bc['tenNguoiGui']) ?> — <?= htmlspecialchars($bc['email']) ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Tour bị báo cáo:</div>
                        <div class="col-md-9">
                            <a href="chiTietTour.php?maTour=<?= $bc['maTour'] ?>" class="text-decoration-none"><?= htmlspecialchars($bc['tenTour']) ?></a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Ngày gửi:</div>
                        <div class="col-md-9"><?= date('d/m/Y H:i', strtotime($bc['ngayGui'])) ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Trạng thái:</div>
                        <div class="col-md-9">
                            <?php if ($bc['trangThaiXuLy'] === 'choPhanHoi'): ?>
                                <span class="badge bg-warning text-dark">Chờ xử lý</span>
                            <?php else: ?>
                                <span class="badge bg-success">Đã xử lý</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Nội dung:</div>
                        <div class="col-md-9"><?= nl2br(htmlspecialchars($bc['noiDung'])) ?></div>
                    </div>

                    <!-- HÀNH ĐỘNG -->
                    <div class="mt-3 d-flex gap-2">
                        <?php if ($bc['trangThaiXuLy'] === 'choPhanHoi'): ?>
                            <a href="../../actions/baoCao/handleReport.php?id=<?= $bc['maBaoCao'] ?>&action=xu_ly"
                                class="btn btn-success"
                                onclick="return confirm('Đánh dấu đã xử lý?')">Đánh dấu xử lý</a>
                        <?php endif; ?>
                        <a href="../../actions/baoCao/handleReport.php?id=<?= $bc['maBaoCao'] ?>&action=xoa"
                            class="btn btn-danger"
                            onclick="return confirm('Xóa báo cáo này?')">Xóa báo cáo</a>
                        <a href="quanLyBaoCaoViPham.php" class="btn btn-secondary">← Quay lại</a>
                    </div>
                </div>

                <!-- PHẢN HỒI -->
                <div class="content-box mb-4">
                    <h5 class="mb-3">Lịch sử phản hồi</h5>
                    <?php if (empty($dsPhanHoi)): ?>
                        <p class="text-muted">Chưa có phản hồi nào.</p>
                    <?php else: ?>
                        <?php foreach ($dsPhanHoi as $ph): ?>
                            <div class="border rounded p-3 mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong><?= htmlspecialchars($ph['tenNguoiGui']) ?></strong>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($ph['ngayGui'])) ?></small>
                                </div>
                                <p class="mb-0"><?= nl2br(htmlspecialchars($ph['noiDung'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- FORM GỬI PHẢN HỒI -->
                <?php if ($bc['trangThaiXuLy'] === 'choPhanHoi'): ?>
                    <div class="content-box">
                        <h5 class="mb-3">Gửi phản hồi</h5>
                        <form action="../../actions/baoCao/replyReport.php" method="POST">
                            <input type="hidden" name="maBaoCao" value="<?= $bc['maBaoCao'] ?>">
                            <div class="mb-3">
                                <textarea name="noiDung" class="form-control" rows="4"
                                    placeholder="Nhập nội dung phản hồi..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                        </form>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>

</html>