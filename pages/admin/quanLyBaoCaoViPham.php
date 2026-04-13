<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo cáo vi phạm</title>
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
                <h3 class="mb-4 text-title">Danh sách báo cáo vi phạm</h3>

                <hr>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <div class="row">

                        <!-- SEARCH -->
                        <div class="col-md-4">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" placeholder="Người gửi hoặc nội dung...">
                        </div>

                        <!-- TRẠNG THÁI -->
                        <div class="col-md-3">
                            <label class="form-label">Trạng thái xử lý</label>
                            <select class="form-select">
                                <option>Tất cả</option>
                                <option>Chưa xử lý</option>
                                <option>Đang xử lý</option>
                                <option>Đã xử lý</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Người gửi</th>
                                <th>Tour</th>
                                <th>Nội dung</th>
                                <th>Ngày gửi</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Dữ liệu mẫu -->
                            <tr>
                                <td>301</td>
                                <td>Nguyễn Văn A</td>
                                <td>Tour Đà Nẵng 3N2Đ</td>
                                <td>Tour có dấu hiệu lừa đảo</td>
                                <td>2026-03-25</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Chưa xử lý</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-success btn-sm">Đánh dấu xử lý</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>

                            <tr>
                                <td>302</td>
                                <td>Trần Thị B</td>
                                <td>Tour Phú Quốc 4N3Đ</td>
                                <td>Thông tin không chính xác</td>
                                <td>2026-03-26</td>
                                <td>
                                    <span class="badge bg-success">Đã xử lý</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
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
