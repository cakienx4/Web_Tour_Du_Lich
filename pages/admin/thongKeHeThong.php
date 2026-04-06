<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thống kê doanh thu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h4 class="text-white text-center mt-3">TAVIVU ADMIN</h4>

                <a href="#" class="row-odd">Quản lý người dùng</a>
                <a href="#" class="row-even">Duyệt tour</a>
                <a href="#" class="row-odd">Danh sách tour</a>
                <a href="#" class="row-even">Đơn đặt tour</a>
                <a href="#" class="row-odd">Quản lý điểm đến</a>
                <a href="#" class="row-even">Danh sách báo cáo vi phạm</a>
                <a href="#" class="row-odd">Danh sách tour vi phạm</a>
                <a href="#" class="row-even active">Thống kê doanh thu</a>
                <a href="#" class="row-odd">Đăng xuất</a>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <!-- TITLE -->
                <h3 class="mb-4 text-title">Thống kê doanh thu</h3>

                <hr>

                <!-- FILTER -->
                <div class="content-box mb-4">
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
                            <label class="form-label">Nhà phân phối</label>
                            <select class="form-select">
                                <option>Tất cả</option>
                                <option>Công ty ABC</option>
                                <option>Du lịch XYZ</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- SUMMARY CARDS -->
                <div class="row mb-4">

                    <div class="col-md-4">
                        <div class="content-box text-center">
                            <h6>Tổng doanh thu</h6>
                            <h4 class="text-success">120.000.000đ</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="content-box text-center">
                            <h6>Tổng số đơn</h6>
                            <h4>85</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="content-box text-center">
                            <h6>Số tour đã bán</h6>
                            <h4>25</h4>
                        </div>
                    </div>

                </div>

                <!-- TABLE DOANH THU -->
                <div class="content-box">

                    <h5 class="mb-3">Doanh thu theo nhà phân phối</h5>

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>Nhà phân phối</th>
                                <th>Số tour</th>
                                <th>Số đơn</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>Công ty ABC</td>
                                <td>10</td>
                                <td>30</td>
                                <td>50.000.000đ</td>
                            </tr>

                            <tr>
                                <td>Du lịch XYZ</td>
                                <td>15</td>
                                <td>55</td>
                                <td>70.000.000đ</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
