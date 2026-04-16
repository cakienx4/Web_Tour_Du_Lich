<?php
require_once '../../config/database.php';

$sql = "
SELECT t.*, u.hoTen 
FROM tour t
JOIN user u ON t.maND = u.maND
WHERE t.trangThai = 'Chờ duyệt'
ORDER BY t.maTour DESC
";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Duyệt tour</title>
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
                <h3 class="mb-4 text-title">Duyệt tour</h3>

                <hr>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_GET['success'] === 'approved' ? 'Đã duyệt tour!' : 'Đã từ chối tour!' ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        Lỗi xảy ra!
                    </div>
                <?php endif; ?>
                <!-- TOOLBAR -->
                <div class="content-box mb-3">
                    <div class="row">

                        <!-- SEARCH -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Tìm kiếm tour...">
                        </div>

                    </div>
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
                            <?php while ($tour = $result->fetch_assoc()): ?>
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
                                        <?= htmlspecialchars($tour['diemDen'] ?? '...') ?>
                                    </td>
                                    <td>
                                        <?= number_format($tour['giaTour'], 0, ',', '.') ?>đ
                                    </td>
                                    <td>
                                        <?= $tour['soChoTrong'] ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                    </td>
                                    <td>
                                        <a href="../khachHang/tour_ChiTiet.php?maTour=<?= $tour['maTour'] ?>"
                                            class="btn btn-info btn-sm">Xem</a>

                                        <a href="../../actions/tour/approveTour.php?id=<?= $tour['maTour'] ?>"
                                            class="btn btn-success btn-sm" onclick="return confirm('Duyệt tour này?')">
                                            Duyệt
                                        </a>

                                        <a href="../../actions/tour/rejectTour.php?id=<?= $tour['maTour'] ?>"
                                            class="btn btn-danger btn-sm" onclick="return confirm('Từ chối tour này?')">
                                            Từ chối
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</body>

</html>