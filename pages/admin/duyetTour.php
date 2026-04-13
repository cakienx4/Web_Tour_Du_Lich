<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Duyệt tour</title>
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
                <h3 class="mb-4 text-title">Duyệt tour</h3>

                <hr>

                <!-- TOOLBAR -->
                <div class="content-box mb-3">
                    <div class="row">

                        <!-- SEARCH -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Tìm kiếm tour...">
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tên tour</th>
                                <th>Nhà phân phối</th>
                                <th>Điểm đến</th>
                                <th>Giá</th>
                                <th>Số chỗ trống</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Dữ liệu mẫu -->
                            <tr>
                                <td>101</td>
                                <td>Tour Đà Nẵng 3N2Đ</td>
                                <td>Công ty ABC</td>
                                <td>Đà Nẵng</td>
                                <td>3.500.000đ</td>
                                <td>30/30</td>
                                <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                                <td>
                                    <a href="chiTietTour.html" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-success btn-sm">Duyệt</button>
                                    <button class="btn btn-danger btn-sm">Từ chối</button>
                                </td>
                            </tr>

                            <tr>
                                <td>102</td>
                                <td>Tour Phú Quốc 4N3Đ</td>
                                <td>Du lịch XYZ</td>
                                <td>Phú Quốc</td>
                                <td>5.200.000đ</td>
                                <td>30/30</td>
                                <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-success btn-sm">Duyệt</button>
                                    <button class="btn btn-danger btn-sm">Từ chối</button>
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
