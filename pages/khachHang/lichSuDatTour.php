<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch sử đặt tour</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/khachHang.css">

</head>

<body>
    <?php include '../../includes/header.php'; ?>
    <div class="breadcrumb-box">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb tour-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link ">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">Trang lịch sử đơn đặt tour </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container my-5">
        <div class="page-title">
            Lịch sử đơn đặt của tôi
        </div>
        <!-- ĐƠN 1 -->
        <div class="box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="tour-title">
                        <p>Tour Đà Nẵng - Hội An 3N2Đ</p>
                    </div>
                    <div class="tour-info">
                        <p>Khám phá Bà Nà Hills, phố cổ Hội An và biển Mỹ Khê.</p>
                        <p>Ngày đặt: 10/03/2026</p>
                        <p>Ngày khởi hành: 20/03/2026</p>
                        <p>Thời gian: 3 ngày 2 đêm</p>
                        <p>
                            Trạng thái:
                            <span class="status status-upcoming">
                                Chưa bắt đầu
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="#cancel1" class="btn btn-outline-danger cancel-btn">
                        Hủy đơn
                    </a>
                </div>
            </div>
        </div>
        <!-- ĐƠN 2 -->
        <div class="box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="tour-title">
                        <p>Tour Phú Quốc 4N3Đ</p>
                    </div>
                    <div class="tour-info">
                        <p>Tham quan VinWonders, cáp treo Hòn Thơm và bãi Sao.</p>
                        <p>Ngày đặt: 02/02/2026</p>
                        <p>Ngày khởi hành: 20/03/2026</p>
                        <p>Thời gian: 3 ngày 2 đêm</p>
                        <p>
                            Trạng thái:
                            <span class="status status-finished">
                                Đã kết thúc
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
</body>

</html>