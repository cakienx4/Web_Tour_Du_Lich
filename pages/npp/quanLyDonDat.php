<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đơn đặt tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/NPP.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php include "../../includes/sideBar-NPP.php";?>


            <!-- CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <h3 class="mb-4 text-title">Danh sách đơn đặt tour</h3>

                <hr>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label"><strong>Tìm kiếm</strong></label>
                            <input type="text" class="form-control" placeholder="Tên khách hàng hoặc tour...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><strong>ID Đơn</strong></label>
                            <input type="text" class="form-control" placeholder="Nhập ID đơn">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label"><strong>ID Tour</strong></label>
                            <input type="text" class="form-control" placeholder="Nhập ID tour">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><strong>Trạng thái</strong></label>
                            <select class="form-select">
                                <option>Tất cả</option>
                                <option>Chờ thanh toán</option>
                                <option>Đã thanh toán</option>
                                <option>Đã hủy</option>
                                <option>Không hợp lệ</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID Đơn</th>
                                <th>ID Tour</th>
                                <th>Khách hàng</th>
                                <th>Tên tour</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Phương thức</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>501</td>
                                <td>201</td>
                                <td>Nguyễn Văn A</td>
                                <td>Tour Đà Nẵng</td>
                                <td>2026-03-20</td>
                                <td>7.000.000đ</td>
                                <td>-</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                                </td>
                                <td>
                                    <a href="booking_detail_provider.html" class="btn btn-info btn-sm">Xem</a>
                                </td>
                            </tr>

                            <tr>
                                <td>502</td>
                                <td>202</td>
                                <td>Trần Thị B</td>
                                <td>Tour Phú Quốc</td>
                                <td>2026-03-18</td>
                                <td>20.800.000đ</td>
                                <td>VNPAY</td>
                                <td>
                                    <span class="badge bg-success">Đã thanh toán</span>
                                </td>
                                <td>
                                    <a href="booking_detail_provider.html" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-secondary btn-sm">Đánh dấu không hợp lệ</button>
                                </td>
                            </tr>

                            <tr>
                                <td>503</td>
                                <td>201</td>
                                <td>Tour Đà Nẵng</td>
                                <td>Lê Văn C</td>
                                <td>2026-03-15</td>
                                <td>3.500.000đ</td>
                                <td>MOMO</td>
                                <td>
                                    <span class="badge bg-danger">Đã hủy</span>
                                </td>
                                <td>
                                    <a href="booking_detail_provider.html" class="btn btn-info btn-sm">Xem</a>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
