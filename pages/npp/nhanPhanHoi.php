<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Phản hồi từ Admin</title>
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
                <a href="#" class="row-even active">Phản hồi từ Admin</a>
                <a href="#" class="row-odd">Thống kê doanh thu</a>
                <a href="#" class="row-even">Đăng xuất</a>
            </div>

            <!-- CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <h3 class="mb-4 text-title">Phản hồi từ Quản trị viên</h3>

                <!-- FILTER -->
                <div class="content-box mb-3">
                    <div class="row">

                        <div class="col-md-4">
                            <label class="form-label">Nội dung</label>
                            <input type="text" class="form-control" placeholder="Tìm theo nội dung">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select">
                                <option>Tất cả</option>
                                <option>Chưa đọc</option>
                                <option>Đã đọc</option>
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
                                <th>Nội dung</th>
                                <th>Ngày gửi</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>Tour Đà Nẵng cần bổ sung hình ảnh</td>
                                <td>2026-03-25</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>Tour Hà Nội bị từ chối do thiếu lịch trình</td>
                                <td>2026-03-24</td>
                                <td>
                                    <span class="badge bg-success">Đã đọc</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
                                    <button class="btn btn-outline-danger btn-sm">Xóa</button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Tour Phú Quốc cần cập nhật giá mới</td>
                                <td>2026-03-23</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">Xem</a>
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
