<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý điểm đến</title>
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
                <h3 class="mb-4 text-title">Quản lý điểm đến</h3>

                <hr>
                
                <!-- FILTER + ADD -->
                <div class="content-box mb-3">
                    <div class="row">

                        <!-- SEARCH -->
                        <div class="col-md-5">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" placeholder="Tên điểm đến...">
                        </div>

                        <!-- REGION -->
                        <div class="col-md-3">
                            <label class="form-label">Vùng miền</label>
                            <select class="form-select">
                                <option>Tất cả</option>
                                <option>Miền Bắc</option>
                                <option>Miền Trung</option>
                                <option>Miền Nam</option>
                            </select>
                        </div>

                        <!-- ADD -->
                        <div class="col-md-4 text-end d-flex align-items-end">
                            <a href="#" class="btn btn-primary">Thêm điểm đến</a>
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tên điểm đến</th>
                                <th>Vùng miền</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Dữ liệu mẫu -->
                            <tr>
                                <td>1</td>
                                <td>Đà Nẵng</td>
                                <td>Miền Trung</td>
                                <td>Thành phố biển nổi tiếng với du lịch</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>Phú Quốc</td>
                                <td>Miền Nam</td>
                                <td>Đảo du lịch nổi tiếng</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Hà Nội</td>
                                <td>Miền Bắc</td>
                                <td>Thủ đô nghìn năm văn hiến</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Sửa</a>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
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
