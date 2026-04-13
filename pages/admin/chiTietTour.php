<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php include "../../includes/sideBar-admin.php";?>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <!-- TITLE -->
                <h3 class="mb-4 text-title">Chi tiết tour</h3>

                <div class="content-box-chiTiet">

                    <div class="title-box-chiTiet mb-3">
                        <!-- TÊN TOUR -->
                        <h4>Tour Đà Nẵng 3N2Đ</h4>
                        <a class="btn btn-primary" href="quanLyDonDat.html">Danh sách đơn đặt</a>
                    </div>

                    <hr>
                    <!-- Mã tour -->
                    <p><strong>Mã tour:</strong> 101</p>

                    <!-- NHÀ PHÂN PHỐI -->
                    <p><strong>Nhà phân phối:</strong> Công ty du lịch ABC</p>

                    <!-- NGÀY KHỞI HÀNH -->
                    <p><strong>Ngày khởi hành:</strong> 30/03/2026</p>

                    <!-- ĐIỂM ĐẾN -->
                    <p><strong>Điểm đến:</strong> Đà Nẵng</p>

                    <!-- GIÁ -->
                    <p><strong>Giá:</strong> 3.500.000đ</p>

                    <!-- SỐ CHỖ TRỐNG -->
                    <p><strong>Số chỗ trống:</strong> 30/30</p>

                    <!-- TRẠNG THÁI -->
                    <p>
                        <strong>Trạng thái:</strong>
                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                    </p>

                    <hr>

                    <!-- MÔ TẢ -->
                    <h5>Mô tả tour</h5>
                    <p>
                        Tour Đà Nẵng 3 ngày 2 đêm với lịch trình hấp dẫn, tham quan Bà Nà Hills, cầu Rồng,
                        bãi biển Mỹ Khê...
                    </p>

                    <!-- LỊCH TRÌNH -->
                    <h5 class="mt-4">Lịch trình</h5>
                    <ul>
                        <li>Ngày 1: Đến Đà Nẵng, tham quan thành phố</li>
                        <li>Ngày 2: Bà Nà Hills</li>
                        <li>Ngày 3: Mua sắm và trở về</li>
                    </ul>

                    <!-- HÌNH ẢNH -->
                    <h5 class="mt-4">Hình ảnh</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/300" class="img-fluid rounded">
                        </div>
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/300" class="img-fluid rounded">
                        </div>
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/300" class="img-fluid rounded">
                        </div>
                    </div>

                    <hr>

                    <!-- ACTION -->
                    <div class="d-flex justify-content-between mb-3">

                        <a href="duyetTour.html" class="btn btn-secondary">
                            ← Quay lại
                        </a>

                        <div>
                            <button class="btn btn-success">Duyệt</button>
                            <button class="btn btn-danger">Từ chối</button>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
