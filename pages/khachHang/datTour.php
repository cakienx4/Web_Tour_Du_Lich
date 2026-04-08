<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/khachHang.css">

    <style>
        .btn:hover {
            background-color: crimson;
        }
    </style>
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
                        <a href="#" class="breadcrumb-link">Tên tour</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container my-4">

        <!-- TOUR INFO -->
        <div class="box tour-summary">

            <div class="row align-items-center">

                <div class="col-md-2">
                    <img src="images/sapa.jpg">
                </div>

                <div class="col-md-10">

                    <div class="tour-title">
                        Tour Sapa 3N2Đ - Khám phá núi rừng Tây Bắc
                    </div>

                    <div class="text-muted tour-info">
                        <p><strong>Thời gian:</strong> 3 ngày 2 đêm</p>
                        <p><strong>Khởi hành:</strong> Hà Nội</p>
                        <p><strong>Phương tiện:</strong> Xe du lịch</p>
                        <p><strong>Số suất vé còn lại:</strong> 12/34</p>
                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <!-- FORM -->
            <div class="col-lg-8">

                <div class="box">

                    <h4 class="mb-3">Thông tin đặt tour</h4>

                    <form action="payment.html" method="POST">

                        <div class="row">

                            <!-- Ngày khởi hành -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Ngày khởi hành</h5>
                                </label>
                                <input type="date" class="form-control" required>
                            </div>

                            <!-- Số người -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Số lượng người</h5>
                                </label>
                                <input type="number" class="form-control" min="1" value="1" required>
                            </div>

                        </div>


                        <h4 class="mt-3">Thông tin liên hệ</h4>

                        <div class="row">

                            <!-- Họ và tên -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Họ và tên</h5>
                                </label>
                                <input type="text" class="form-control" required>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <h5>Số điện thoại</h5>
                                </label>
                                <input type="tel" class="form-control" required>
                            </div>

                        </div>

                </div>

            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">

                <div class="box">

                    <h4>Đơn đặt</h4>

                    <hr>

                    <p>
                        <strong>Giá tour: </strong><span class="price">3.990.000đ</span>
                    </p>

                    <p>
                        <strong>Số khách:</strong> 1
                    </p>

                    <hr>

                    <h5>
                        Tổng tiền: <span class="price">3.990.000đ</span>
                    </h5>

                    <button class="btn btn-book text-white mt-3">
                        Gửi yêu cầu đặt tour
                    </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>