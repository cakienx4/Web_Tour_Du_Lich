<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết báo cáo vi phạm</title>
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

                <h3 class="mb-4 text-title">Chi tiết báo cáo vi phạm</h3>

                <div class="content-box-chiTiet">

                    <!-- THÔNG TIN BÁO CÁO -->
                    <h4 class="mb-3">Thông tin báo cáo</h4>
                    <p><strong>ID báo cáo:</strong> 301</p>
                    <p><strong>Ngày gửi:</strong> 2026-03-25</p>
                    <p>
                        <strong>Trạng thái:</strong>
                        <span class="badge bg-warning text-dark">Chưa xử lý</span>
                    </p>

                    <hr>

                    <!-- NGƯỜI GỬI -->
                    <h4 class="mb-3">Người gửi</h4>
                    <p><strong>Họ tên:</strong> Nguyễn Văn A</p>
                    <p><strong>Email:</strong> nguyenvana@example.com</p>
                    <p><strong>Số điện thoại:</strong> 0123456789</p>

                    <hr>

                    <!-- TOUR BỊ BÁO CÁO -->
                    <h4 class="mb-3">Tour bị báo cáo</h4>
                    <p><strong>ID Tour:</strong> 201</p>
                    <p><strong>Tên tour:</strong> Tour Đà Nẵng 3N2Đ</p>
                    <p><strong>Điểm đến:</strong> Đà Nẵng</p>

                    <!-- LINK SANG TOUR -->
                    <a href="tour_detail_admin.html" class="btn btn-info btn-sm mb-3">
                        Xem chi tiết tour
                    </a>

                    <hr>

                    <!-- NỘI DUNG -->
                    <h5>Nội dung báo cáo</h5>
                    <p>
                        Tour có dấu hiệu lừa đảo, thông tin không đúng với thực tế.
                        Giá hiển thị khác với khi thanh toán.
                    </p>

                    <hr>

                    <!-- ACTION -->
                    <div class="d-flex justify-content-between action-group">

                        <a href="quanLyBaoCaoViPham.html" class="btn btn-secondary">
                            ← Quay lại
                        </a>

                        <div>
                            <button class="btn btn-danger ">
                                Xóa
                            </button>

                            <button class="btn btn-success">
                                Đánh dấu xử lý
                            </button>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
