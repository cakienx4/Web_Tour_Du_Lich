<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/khachHang.css">
</head>

<body>

    <?php include '../../includes/header.php'; ?>

    <!-- ------------------------------------- BANNER - THANH TÌM KIẾM ------------------------------------- -->

    <section class="hero">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>Khám phá Tour Du Lịch Việt Nam</h1>
                <p>Muôn vàn tour trong nước – Giá tốt – Khởi hành mỗi ngày</p>

                <form class="search-box">
                    <select>
                        <option>Chọn điểm đến</option>
                        <option>Đà Nẵng</option>
                        <option>Phú Quốc</option>
                        <option>Hà Nội</option>
                        <option>Đà Lạt</option>
                    </select>

                    <input type="date">

                    <select>
                        <option>Số ngày</option>
                        <option>1 – 3 ngày</option>
                        <option>4 – 7 ngày</option>
                        <option>Trên 7 ngày</option>
                    </select>

                    <button type="submit">Tìm tour</button>
                </form>
            </div>
        </div>
    </section>

    <!-- ------------------------------------- WHY CHOOSE US ------------------------------------- -->

    <section class="why-choose-us">
        <h2 class="section-title">TAVIVU - Đại lí du lịch hàng đầu!</h2>

        <div class="reason-grid">
            <div class="reason-card">
                <h3>Tour chất lượng</h3>
                <p>Lịch trình tối ưu, điểm đến hấp dẫn, trải nghiệm thực tế.</p>
            </div>

            <div class="reason-card">
                <h3>Giá cả minh bạch</h3>
                <p>Không phí ẩn, giá tốt nhất.</p>
            </div>

            <div class="reason-card">
                <h3>Hỗ trợ 24/7</h3>
                <p>Đội ngũ tư vấn luôn sẵn sàng hỗ trợ mọi lúc.</p>
            </div>

            <div class="reason-card">
                <h3>Thanh toán an toàn</h3>
                <p>Hỗ trợ VNPay, MoMo, bảo mật thông tin tuyệt đối.</p>
            </div>
        </div>
    </section>

    <!-- ------------------------------------- DANH SÁCH TOUR NỔI BẬT ------------------------------------- -->

    <section class="destinations">
        <div class="container-fluid p-0">
            <!-- MIỀN BẮC -->
            <div class="region" style="background-color: #FFF3E0;">
                <h2>Tour Miền Bắc</h2>

                <div class="destination-list">
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Sapa</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>

                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="Hà Nội">
                        </div>

                        <div class="card-content">
                            <h3>Tour Hà Nội</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Hạ Long</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Ninh Bình</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                </div>

                <div class="view-more">
                    <a href="#">Xem thêm tour</a>
                </div>
            </div>

            <!-- MIỀN TRUNG -->
            <div class="region" style="background-color:#EBF0F2;">
                <h2>Tour Miền Trung</h2>

                <div class="destination-list">
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Đà Nẵng</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Hội An</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Huế </h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Nha Trang </h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>

                    </a>
                </div>

                <div class="view-more">
                    <a href="#">Xem thêm tour</a>
                </div>
            </div>

            <!-- MIỀN NAM -->
            <div class="region" style="background-color:#FFF3E0;">
                <h2>Tour Miền Nam</h2>

                <div class="destination-list">
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Phú Quốc</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour TP. Hồ Chí Minh</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>

                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Cần Thơ</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                    <a href="#" class="destination-item">
                        <div class="card-image">
                            <img src="#" alt="?">
                        </div>

                        <div class="card-content">
                            <h3>Tour Vũng Tàu</h3>
                            <p class="duration">3 ngày 2 đêm</p>
                            <p class="price">Từ 3.990.000đ</p>
                        </div>
                    </a>
                </div>

                <div class="view-more">
                    <a href="#">Xem thêm tour</a>
                </div>
            </div>

        </div>
    </section>

    <!-- ------------------------------------- FOOTER ------------------------------------- -->
    <?php include '../../includes/footer.php'; ?>

</body>

</html>