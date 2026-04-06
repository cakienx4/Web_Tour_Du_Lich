<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/NPP.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h4 class="text-white text-center mt-3">TAVIVU PROVIDER</h4>

                <a href="#" class="row-odd active">Tour đã tạo</a>
                <a href="#" class="row-even">Tạo tour</a>
                <a href="#" class="row-odd">Đơn đặt tour</a>
                <a href="#" class="row-even">Phản hồi từ Admin</a>
                <a href="#" class="row-odd">Thống kê doanh thu</a>
                <a href="#" class="row-even">Đăng xuất</a>
            </div>

            <!-- CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <h3 class="mb-4 text-title">Chi tiết tour</h3>

                <div class="content-box-chiTiet">

                    <div class="title-box-chiTiet mb-3">
                        <!-- TÊN TOUR -->
                        <h4 class="m-0">Tour Đà Nẵng</h4>
                        <button class="btn btn-info">Chỉnh sửa tour</button>
                    </div>

                    <hr>

                    <p><strong>ID:</strong> 201</p>
                    <p><strong>Điểm đến:</strong> Đà Nẵng</p>
                    <p><strong>Giá:</strong> 3.500.000đ</p>
                    <p><strong>Ngày khởi hành:</strong> 2026-04-10</p>
                    <p><Strong>Thời gian:</Strong> 3 ngày 2 đêm</p>
                    <p><strong>Số chỗ còn:</strong> 20</p>
                    <p><strong>Trạng thái:</strong>
                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                    </p>

                    <hr>

                    <!-- HÌNH ẢNH -->
                    <div class="col-md-5">
                        <img src="../../images/tour1.jpg" class="img-fluid rounded" alt="Tour image">
                    </div>

                    <hr>
                    
                    <h5>Mô tả</h5>
                    <p>
                        Tour tham quan Đà Nẵng, Hội An, Bà Nà Hills...
                    </p>

                    <hr>

                    <div class="d-flex justify-content-between action-group">
                        <a href="my_tours.html" class="btn btn-secondary">
                            ← Quay lại
                        </a>

                        <a href="#" class="btn btn-primary">
                            Xem đơn đặt
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
