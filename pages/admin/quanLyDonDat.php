<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn đặt tour</title>
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
                <h3 class="mb-4 text-title">Quản lý đơn đặt tour</h3>

                <hr>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <div class="row">

                        <!-- SEARCH -->
                        <div class="col-md-4">
                            <label class="form-label"><strong>Tìm kiếm</strong></label>
                            <input type="text" class="form-control" placeholder="Tên khách hàng hoặc tour...">
                        </div>

                        <!-- ID đơn -->
                        <div class="col-md-2">
                            <label class="form-label"><strong>ID đơn</strong></label>
                            <input type="text" class="form-control" placeholder="Nhập ID đơn">
                        </div>

                        <!-- ID tour -->
                        <div class="col-md-2">
                            <label class="form-label"><strong>ID Tour</strong></label>
                            <input type="text" class="form-control" placeholder="Nhập ID tour">
                        </div>

                        <!-- TRẠNG THÁI -->
                        <div class="col-md-3">
                            <label class="form-label"><strong>Trạng thái thanh toán</strong></label>
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
                                <th>ID đơn</th>
                                <th>ID tour</th>
                                <th>Khách hàng</th>
                                <th>Tour</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Phương thức</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Dữ liệu mẫu -->
                            <tr>
                                <td>501</td>
                                <td>101</td>
                                <td>Nguyễn Văn A</td>
                                <td>Tour Đà Nẵng 3N2Đ</td>
                                <td>2026-03-20</td>
                                <td>3.500.000đ</td>
                                <td>MOMO</td>
                                <td><span class="badge bg-success">Đã thanh toán</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-primary btn-sm">Cập nhật trạng thái</button>
                                </td>
                            </tr>

                            <tr>
                                <td>502</td>
                                <td>102</td>
                                <td>Trần Thị B</td>
                                <td>Tour Phú Quốc 4N3Đ</td>
                                <td>2026-03-22</td>
                                <td>5.200.000đ</td>
                                <td>-</td>
                                <td><span class="badge bg-warning text-dark">Chờ thanh toán</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-primary btn-sm">Cập nhật trạng thái</button>
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
