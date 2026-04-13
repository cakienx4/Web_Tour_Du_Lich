<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
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

                <div class="mb-4">
                    <h3 class="text-title">Quản lý người dùng</h3>
                </div>

                <hr>
                
                <div class="content-box mb-3">
                    <div class="row">

                        <!-- ---------------------- Tìm kiếm ---------------------- -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Tìm kiếm theo tên hoặc email...">
                        </div>

                        <!-- ---------------------- Lọc ---------------------- -->
                        <div class="col-md-3">
                            <select class="form-select">
                                <option>Tất cả vai trò</option>
                                <option>Khách hàng</option>
                                <option>Nhà phân phối</option>
                            </select>
                        </div>

                        <!-- ------------- Nút Thêm người dùng -------------------  -->
                        <div class="col-md-3 text-end">
                            <button class="btn btn-primary">+ Thêm người dùng</button>
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
                <div class="content-box">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>Nguyễn Văn A</td>
                                <td>a@gmail.com</td>
                                <td>0123456789</td>
                                <td><span class="badge bg-primary">Admin</span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Sửa</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>Trần Thị B</td>
                                <td>b@gmail.com</td>
                                <td>0123456789</td>
                                <td><span class="badge bg-success">Khách hàng</span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Sửa</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Lê Văn C</td>
                                <td>c@gmail.com</td>
                                <td>0123456789</td>
                                <td><span class="badge bg-info text-dark">Nhà phân phối</span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Sửa</button>
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
