<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo tour</title>
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

                <h3 class="mb-4 text-title">Tạo tour mới</h3>

                <hr>

                <div class="content-box">

                    <form>

                        <div class="row">

                            <!-- TÊN TOUR -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"> <strong>Tên tour</strong> </label>
                                <input type="text" class="form-control">
                            </div>

                            <!-- GIÁ -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"> <strong>Giá (VNĐ)</strong> </label>
                                <input type="number" class="form-control">
                            </div>

                            <!-- NGÀY KHỞI HÀNH -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"> <strong>Ngày khởi hành</strong> </label>
                                <input type="date" class="form-control">
                            </div>

                            <!-- SỐ NGÀY -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label"> <strong>Số ngày</strong> </label>
                                <input type="number" class="form-control" placeholder="Ví dụ: 3">
                            </div>

                            <!-- SỐ ĐÊM -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label"> <strong>Số đêm</strong> </label>
                                <input type="number" class="form-control" placeholder="Ví dụ: 2">
                            </div>

                            <!-- SỐ LƯỢNG -->
                            <div class="col-md-2 mb-3">
                                <label class="form-label"> <strong>Số lượng khách</strong> </label>
                                <input type="number" class="form-control">
                            </div>

                            <!-- ĐIỂM ĐẾN -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"> <strong>Điểm đến</strong> </label>
                                <select class="form-select">
                                    <option>Chọn điểm đến</option>
                                    <option>Đà Nẵng</option>
                                    <option>Phú Quốc</option>
                                    <option>Hà Nội</option>
                                </select>
                            </div>

                            <!-- ẢNH -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label"> <strong>Hình ảnh</strong> </label>
                                <input type="file" class="form-control" multiple>
                            </div>

                            <!-- MÔ TẢ -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label"> <strong>Mô tả</strong> </label>
                                <textarea class="form-control" rows="4"></textarea>
                            </div>

                        </div>

                        <!-- ACTION -->
                        <div class="d-flex justify-content-end action-group">
                            <button type="submit" class="btn btn-success">
                                Tạo tour
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
