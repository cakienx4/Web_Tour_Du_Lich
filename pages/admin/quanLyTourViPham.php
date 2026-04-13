<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách tour vi phạm</title>
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
                <h3 class="mb-4 text-title">Danh sách tour vi phạm</h3>

                <hr>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <div class="row">

                        <!-- SEARCH -->
                        <div class="col-md-4">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" placeholder="Tên tour hoặc nhà phân phối...">
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID Tour</th>
                                <th>Tên tour</th>
                                <th>Điểm đến</th>
                                <th>Nhà phân phối</th>
                                <th>Lý do vi phạm</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Dữ liệu mẫu -->
                            <tr>
                                <td>201</td>
                                <td>Tour Đà Nẵng 3N2Đ</td>
                                <td>Đà Nẵng</td>
                                <td>Công ty ABC</td>
                                <td>Thông tin sai lệch, giá không minh bạch</td>
                                <td>
                                    <span class="badge bg-primary">Đang xử lý</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-danger btn-sm">Gỡ tour</button>
                                    <button class="btn btn-success btn-sm">Khôi phục</button>
                                </td>
                            </tr>

                            <tr>
                                <td>202</td>
                                <td>Tour Phú Quốc 4N3Đ</td>
                                <td>Phú Quốc</td>
                                <td>Du lịch XYZ</td>
                                <td>Nội dung không đúng thực tế</td>
                                <td>
                                    <span class="badge bg-primary">Đang xử lý</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-danger btn-sm">Gỡ tour</button>
                                    <button class="btn btn-success btn-sm">Khôi phục</button>
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
