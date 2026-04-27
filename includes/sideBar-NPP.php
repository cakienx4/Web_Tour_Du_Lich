<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<div class="col-md-3 col-lg-2 sidebar">
    <h4 class="text-white text-center mt-3">TAVIVU PROVIDER</h4>

    <a href="taoTour.php" 
        class="row-even <?= $currentPage === 'taoTour.php' ? 'active' : '' ?>">Tạo tour</a>
    <a href="quanLyTours.php" 
        class="row-odd <?= $currentPage === 'quanLyTours.php' ? 'active' : '' ?>">Tour đã tạo</a>
    <a href="quanLyDonDat.php" 
        class="row-even <?= $currentPage === 'quanLyDonDat.php' ? 'active' : '' ?>">Đơn đặt tour</a>
    <a href="nhanPhanHoi.php" 
        class="row-odd <?= $currentPage === 'nhanPhanHoi.php' ? 'active' : '' ?>">Phản hồi từ Admin</a>
    <a href="thongKeDoanhThu.php" 
        class="row-even <?= $currentPage === 'thongKeDoanhThu.php' ? 'active' : '' ?>">Thống kê doanh thu</a>
    <a href="../../actions/logout.php" class="row-even">Đăng xuất</a>
</div>