<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="col-md-3 col-lg-2 sidebar">
    <h4 class="text-white text-center mt-3">TAVIVU ADMIN</h4>
    <a href="quanLyUsers.php" class="<?= $currentPage === 'quanLyUsers.php' ? 'row-even active' : 'row-even' ?>">Quản lý người dùng</a>
    <a href="duyetTour.php" class="<?= $currentPage === 'duyetTour.php' ? 'row-odd active' : 'row-odd' ?>">Duyệt tour</a>
    <a href="quanLyTours.php" class="<?= $currentPage === 'quanLyTours.php' ? 'row-even active' : 'row-even' ?>">Danh sách tour</a>
    <a href="quanLyDonDat.php" class="<?= $currentPage === 'quanLyDonDat.php' ? 'row-odd active' : 'row-odd' ?>">Đơn đặt tour</a>
    <a href="quanLyDiemDen.php" class="<?= $currentPage === 'quanLyDiemDen.php' ? 'row-even active' : 'row-even' ?>">Quản lý điểm đến</a>
    <a href="quanLyBaoCaoViPham.php" class="<?= $currentPage === 'quanLyBaoCaoViPham.php' ? 'row-odd active' : 'row-odd' ?>">Báo cáo vi phạm</a>
    <a href="quanLyTourViPham.php" class="<?= $currentPage === 'quanLyTourViPham.php' ? 'row-even active' : 'row-even' ?>">Tour vi phạm</a>
    <a href="thongKeHeThong.php" class="<?= $currentPage === 'thongKeHeThong.php' ? 'row-odd active' : 'row-odd' ?>">Thống kê doanh thu</a>
    <a href="../../actions/logout.php" class="row-even">Đăng xuất</a>
</div>