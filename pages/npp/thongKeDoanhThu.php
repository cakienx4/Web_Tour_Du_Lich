<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thống kê doanh thu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h4 class="text-white text-center mt-3">TAVIVU PROVIDER</h4>

                <a href="#" class="row-odd">Tour đã tạo</a>
                <a href="#" class="row-even">Tạo tour</a>
                <a href="#" class="row-odd">Đơn đặt tour</a>
                <a href="#" class="row-even">Phản hồi từ Admin</a>
                <a href="#" class="row-odd active">Thống kê doanh thu</a>
                <a href="#" class="row-even">Đăng xuất</a>
            </div>

            <!-- CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <h3 class="mb-4 text-title">Thống kê doanh thu</h3>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <div class="row">

                        <div class="col-md-3">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tên tour</label>
                            <input type="text" class="form-control" placeholder="Nhập tên tour">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">ID tour</label>
                            <input type="text" class="form-control" placeholder="Nhập mã tour">
                        </div>

                    </div>
                </div>

                <!-- TỔNG QUAN -->
                <div class="row mb-3">

                    <div class="col-md-4">
                        <div class="content-box text-center">
                            <h5>Tổng doanh thu</h5>
                            <h4 class="text-success">27.800.000đ</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="content-box text-center">
                            <h5>Số tour đã bán</h5>
                            <h4>2</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="content-box text-center">
                            <h5>Tổng số khách</h5>
                            <h4>12</h4>
                        </div>
                    </div>

                </div>

                <!-- BẢNG DOANH THU -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID Tour</th>
                                <th>Tên tour</th>
                                <th>Số đơn</th>
                                <th>Số khách</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>201</td>
                                <td>Tour Đà Nẵng</td>
                                <td>3</td>
                                <td>6</td>
                                <td>21.000.000đ</td>
                            </tr>

                            <tr>
                                <td>202</td>
                                <td>Tour Phú Quốc</td>
                                <td>2</td>
                                <td>6</td>
                                <td>6.800.000đ</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
