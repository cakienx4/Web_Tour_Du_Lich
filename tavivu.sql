-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3300
-- Thời gian đã tạo: Th6 04, 2026 lúc 07:31 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tavivu`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baocao`
--

CREATE TABLE `baocao` (
  `maBaoCao` int(10) UNSIGNED NOT NULL,
  `maTour` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `noiDung` text NOT NULL,
  `ngayGui` date NOT NULL,
  `trangThaiXuLy` enum('choPhanHoi','daXuLy') NOT NULL DEFAULT 'choPhanHoi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `baocao`
--

INSERT INTO `baocao` (`maBaoCao`, `maTour`, `maND`, `noiDung`, `ngayGui`, `trangThaiXuLy`) VALUES
(1, 12, 1, 'Dấu hiệu lừa đảo: Tour trông điêu điêu', '2026-04-12', 'daXuLy'),
(2, 10, 1, 'Khác: Đi có 1 ngày nghe điêu điêu', '2026-04-22', 'daXuLy'),
(3, 9, 1, 'Khác: Không lỗi gì đâu, chỉ là muốn chào admin một câu, hihi <3', '2026-04-22', 'daXuLy'),
(4, 1, 1, 'Thông tin không chính xác: Giới thiệu tour bảo khám phá mùa hoa đào nở rộ mà khi đến nới thì không cho đi đến nơi có hoa đào????', '2026-04-22', 'daXuLy'),
(6, 14, 4, 'Khác: test', '2026-06-03', 'daXuLy'),
(8, 21, 4, 'Giá không minh bạch: Nhìn lịch trình trông điêu quá', '2026-06-04', 'daXuLy'),
(9, 20, 1, 'Dịch vụ không đúng cam kết: Sai dịch vụ', '2026-06-05', 'daXuLy'),
(10, 32, 4, 'Dấu hiệu lừa đảo: Đi quá nhiều nơi trong quá nhiều ngày', '2026-06-05', 'daXuLy'),
(11, 23, 4, 'Dịch vụ không đúng cam kết: test', '2026-06-05', 'daXuLy'),
(12, 32, 1, 'Giá không minh bạch: Giá quá cao', '2026-06-05', 'choPhanHoi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diemden`
--

CREATE TABLE `diemden` (
  `maDiemDen` int(10) UNSIGNED NOT NULL,
  `tenDiemDen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `moTa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anhDiemDen` varchar(255) DEFAULT NULL,
  `vungMien` enum('Bắc','Trung','Nam') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `diemden`
--

INSERT INTO `diemden` (`maDiemDen`, `tenDiemDen`, `moTa`, `anhDiemDen`, `vungMien`) VALUES
(1, 'Sapa', 'Thị trấn mù sương vùng Tây Bắc', 'assets/img/diemden/sapa.jpg', 'Bắc'),
(2, 'Hà Nội', 'Thủ đô ngàn năm văn hiến', 'assets/img/diemden/hanoi.jpg', 'Bắc'),
(3, 'Hạ Long', 'Vịnh biển kỳ quan thế giới', 'assets/img/diemden/halong.jpg', 'Bắc'),
(4, 'Ninh Bình', 'Vùng đất cố đô lịch sử', 'assets/img/diemden/ninhbinh.jpg', 'Bắc'),
(5, 'Đà Nẵng', 'Thành phố đáng sống nhất Việt Nam', 'assets/img/diemden/danang.jpg', 'Trung'),
(6, 'Hội An', 'Phố cổ di sản thế giới', 'assets/img/diemden/hoian.jpg', 'Trung'),
(7, 'Huế', 'Cố đô triều Nguyễn', 'assets/img/diemden/hue.jpg', 'Trung'),
(8, 'Nha Trang', 'Thành phố biển xinh đẹp', 'assets/img/diemden/nhatrang.jpg', 'Trung'),
(9, 'Phú Quốc', 'Đảo ngọc miền Nam', 'assets/img/diemden/phuquoc.jpg', 'Nam'),
(10, 'TP. Hồ Chí Minh', 'Thành phố năng động nhất cả nước', 'assets/img/diemden/saigon.jpg', 'Nam'),
(11, 'Cần Thơ', 'Thủ phủ miền Tây sông nước', 'assets/img/diemden/cantho.jpg', 'Nam'),
(12, 'Vũng Tàu', 'Thành phố biển gần Sài Gòn', 'assets/img/diemden/vungtau.jpg', 'Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dondat`
--

CREATE TABLE `dondat` (
  `maDon` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `maTour` int(10) UNSIGNED NOT NULL,
  `ngayKhoiHanh` date NOT NULL,
  `thoiGianDat` datetime NOT NULL DEFAULT current_timestamp(),
  `soNguoi` int(11) NOT NULL,
  `tongTien` decimal(18,2) NOT NULL,
  `phuongThucTT` enum('MoMo','VNPay') DEFAULT NULL,
  `thoiGianThanhToan` datetime DEFAULT NULL,
  `trangThaiTT` enum('Chờ thanh toán','Đã thanh toán','Đã hủy','Hết hạn') NOT NULL DEFAULT 'Chờ thanh toán'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dondat`
--

INSERT INTO `dondat` (`maDon`, `maND`, `maTour`, `ngayKhoiHanh`, `thoiGianDat`, `soNguoi`, `tongTien`, `phuongThucTT`, `thoiGianThanhToan`, `trangThaiTT`) VALUES
(10, 1, 11, '2026-05-22', '2026-04-23 09:23:53', 2, 5600000.00, 'MoMo', '2026-04-23 09:23:54', 'Đã thanh toán'),
(12, 1, 12, '2026-05-25', '2026-04-23 10:18:55', 2, 4400000.00, 'VNPay', '2026-04-23 10:19:24', 'Đã thanh toán'),
(13, 1, 8, '2026-05-20', '2026-05-27 21:59:43', 1, 4800000.00, NULL, NULL, 'Hết hạn'),
(14, 4, 6, '2026-06-02', '2026-05-30 14:44:50', 3, 10500000.00, 'VNPay', '2026-05-30 14:44:52', 'Đã thanh toán'),
(15, 4, 14, '2026-06-03', '2026-05-30 14:45:04', 1, 3290000.00, NULL, NULL, 'Hết hạn'),
(16, 4, 25, '2026-06-06', '2026-06-04 23:11:52', 1, 3800000.00, 'MoMo', '2026-06-04 23:11:53', 'Đã thanh toán'),
(17, 4, 23, '2026-06-06', '2026-06-05 00:00:57', 1, 2300000.00, 'VNPay', '2026-06-05 00:01:00', 'Đã thanh toán'),
(19, 4, 22, '2026-07-09', '2026-06-05 00:01:27', 1, 2900000.00, 'VNPay', '2026-06-05 00:01:29', 'Đã thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanhoi`
--

CREATE TABLE `phanhoi` (
  `maPhanHoi` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `maBaoCao` int(10) UNSIGNED DEFAULT NULL,
  `noiDung` text NOT NULL,
  `ngayGui` date NOT NULL,
  `trangThai` enum('chuaXem','daXem') NOT NULL DEFAULT 'chuaXem'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phanhoi`
--

INSERT INTO `phanhoi` (`maPhanHoi`, `maND`, `maBaoCao`, `noiDung`, `ngayGui`, `trangThai`) VALUES
(1, 5, 2, 'Tour này đang bị báo cáo, cần phải tạm dừng tour', '2026-04-28', 'daXem'),
(11, 6, NULL, 'Tour \"ádasd\" đã bị từ chối. Lý do: Thông tin tour lỗi', '2026-06-04', 'chuaXem'),
(12, 5, NULL, 'Tour \"ádasdasd\" đã bị từ chối. Lý do: sai thông tin', '2026-06-04', 'daXem'),
(14, 5, 9, 'Tour \"Phố Cổ Hội An - Dấu Ấn Thời Gian\" đã được khôi phục. báo động giả', '2026-06-05', 'daXem'),
(15, 5, 10, 'Tour \"Xuyên Việt\" đã bị báo cáo và tạm dừng. Lý do: Có báo cáo vi phạm nên cần kiểm tra', '2026-06-05', 'daXem'),
(16, 5, 8, 'Tour \"Đà Nẵng - Thành Phố Đáng Sống\" đã bị báo cáo và tạm dừng. Lý do: a', '2026-06-05', 'daXem'),
(17, 5, 10, 'Tour \"Xuyên Việt\" đã được khôi phục. ok', '2026-06-05', 'chuaXem'),
(18, 5, 8, 'Tour \"Đà Nẵng - Thành Phố Đáng Sống\" đã được khôi phục. ok', '2026-06-05', 'daXem'),
(19, 6, 11, 'Tour \"Ninh Bình - Tuyệt Tác \"Hạ Long Trên Cạn\"\" đã bị báo cáo và tạm dừng. Lý do: test', '2026-06-05', 'chuaXem');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour`
--

CREATE TABLE `tour` (
  `maTour` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `tenTour` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `moTa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lichTrinh` text DEFAULT NULL,
  `giaTour` decimal(18,2) UNSIGNED NOT NULL,
  `ngayKhoiHanh` date NOT NULL,
  `diemXuatPhat` varchar(100) NOT NULL DEFAULT 'Hà Nội',
  `soNgay` int(11) NOT NULL DEFAULT 1,
  `soChoTrong` int(10) UNSIGNED NOT NULL,
  `tongSoCho` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `trangThai` enum('Chờ duyệt','Đang bán','Tạm dừng','Từ chối','Đã kết thúc') NOT NULL DEFAULT 'Chờ duyệt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tour`
--

INSERT INTO `tour` (`maTour`, `maND`, `tenTour`, `moTa`, `lichTrinh`, `giaTour`, `ngayKhoiHanh`, `diemXuatPhat`, `soNgay`, `soChoTrong`, `tongSoCho`, `trangThai`) VALUES
(1, 5, 'Tour Sapa Mùa Hoa', 'Khám phá Sapa mùa hoa đào nở rộ', 'Ngày 1: Hà Nội – Sapa. Khởi hành từ Hà Nội lên Sapa bằng xe du lịch, nhận phòng khách sạn, tự do khám phá thị trấn Sapa về đêm.\r\nNgày 2: Fansipan – Bản Cát Cát. Tham quan đỉnh Fansipan bằng cáp treo, buổi chiều khám phá bản Cát Cát, tìm hiểu văn hóa người H\'Mông.\r\nNgày 3: Sapa – Hà Nội. Buổi sáng tự do tham quan chợ Sapa, mua sắm đặc sản, trưa lên xe về Hà Nội.', 3990000.00, '2026-05-01', 'Hà Nội', 3, 20, 20, 'Đã kết thúc'),
(2, 5, 'Tour Hà Nội Cổ Kính', 'Tham quan 36 phố phường Hà Nội', 'Ngày 1: Đà Nẵng - Hà Nội. Tham quan Hồ Hoàn Kiếm, Đền Ngọc Sơn, dạo phố cổ 36 phố phường, thưởng thức ẩm thực đường phố.\r\nNgày 2: Di tích lịch sử. Tham quan Lăng Bác, Bảo tàng Hồ Chí Minh, Chùa Một Cột, Văn Miếu Quốc Tử Giám.\r\nNgày 3: Hà Nội – Về. Buổi sáng tự do mua sắm tại chợ Đồng Xuân, trưa kết thúc chương trình.', 2500000.00, '2026-05-05', 'Đà Nẵng', 3, 15, 15, 'Đã kết thúc'),
(3, 5, 'Tour Hạ Long 3N2Đ', 'Ngủ thuyền trên vịnh Hạ Long', 'Ngày 1: Hà Nội – Hạ Long. Khởi hành từ Hà Nội, xuống tàu tham quan vịnh, khám phá hang Sửng Sốt, chèo kayak.\r\nNgày 2: Vịnh Hạ Long. Tham quan làng chài Cửa Vạn, leo núi Bài Thơ, tắm biển, câu mực đêm trên vịnh.\r\nNgày 3: Hạ Long – Hà Nội. Buổi sáng tập Thái Cực Quyền trên tàu, ăn sáng, rời tàu về Hà Nội.', 5500000.00, '2026-05-10', 'Hà Nội', 3, 25, 25, 'Đã kết thúc'),
(4, 5, 'Tour Ninh Bình Tràng An', 'Khám phá Tràng An, Tam Cốc', 'Ngày 1: Hà Nội – Ninh Bình. Khởi hành từ Hà Nội, tham quan Tràng An bằng thuyền, khám phá hang động kỳ bí.\r\nNgày 2: Tam Cốc – Cố đô Hoa Lư. Chèo thuyền Tam Cốc, tham quan đền vua Đinh – vua Lê, leo núi Mùa Hè.', 2990000.00, '2026-05-15', 'Hà Nội', 2, 18, 18, 'Đã kết thúc'),
(5, 5, 'Tour Đà Nẵng Biển Xanh', 'Tắm biển Mỹ Khê, cầu Rồng', 'Ngày 1: Đà Nẵng. Đón khách tại sân bay, tham quan cầu Rồng, bãi biển Mỹ Khê, dạo bờ biển buổi tối.\r\nNgày 2: Bà Nà Hills. Cáp treo lên Bà Nà, tham quan cầu Vàng, vườn hoa Le Jardin, khu vui chơi Fantasy Park.\r\nNgày 3: Hội An. Tham quan phố cổ Hội An, thả đèn hoa đăng trên sông Hoài, mua sắm đặc sản.\r\nNgày 4: Đà Nẵng – Về. Buổi sáng tự do tắm biển, trưa ra sân bay về.', 4200000.00, '2026-05-08', 'Hà Nội', 4, 20, 20, 'Đã kết thúc'),
(6, 5, 'Tour Hội An Đèn Lồng', 'Dạo phố cổ Hội An về đêm!', 'Ngày 1: Hội An. Đón khách, nhận phòng, dạo phố cổ buổi chiều, thưởng thức Cao Lầu và Mì Quảng đặc sản.\r\nNgày 2: Khám phá Hội An. Tham quan chùa Cầu, nhà cổ Tấn Ký, làng gốm Thanh Hà, buổi tối thả đèn hoa đăng.\r\nNgày 3: Làng rau Trà Quế – Về. Tham quan làng rau Trà Quế, học nấu ăn, buổi trưa kết thúc chương trình.', 3500000.00, '2026-06-02', 'Hà Nội', 3, 12, 15, 'Đã kết thúc'),
(7, 5, 'Tour Huế Cung Đình', 'Tham quan Đại Nội, lăng tẩm', 'Ngày 1: Huế. Đón khách, tham quan Đại Nội – Hoàng Thành Huế, dạo thuyền trên sông Hương buổi tối.\r\nNgày 2: Lăng tẩm. Tham quan Lăng Khải Định, Lăng Minh Mạng, Chùa Thiên Mụ, thưởng thức ẩm thực cung đình.\r\nNgày 3: Huế – Về. Buổi sáng tham quan chợ Đông Ba, mua sắm đặc sản, kết thúc chương trình.', 3200000.00, '2026-05-18', 'Hà Nội', 3, 20, 20, 'Đã kết thúc'),
(8, 5, 'Tour Nha Trang Đảo', 'Lặn ngắm san hô, đảo Bình Ba', 'Ngày 1: Nha Trang. Khởi hành từ Hà Nội, nhận phòng resort, tắm biển tự do buổi chiều.\r\nNgày 2: Tour đảo. Tham quan đảo Hòn Mun lặn ngắm san hô, đảo Hòn Tằm, câu cá, ăn hải sản tươi trên biển.\r\nNgày 3: Đảo Bình Ba. Khám phá đảo tôm hùm Bình Ba, tắm biển, thưởng thức hải sản đặc sản.\r\nNgày 4: Nha Trang – Về. Buổi sáng tham quan tháp Bà Ponagar, chợ Đầm, trưa ra sân bay.', 4800000.00, '2026-05-20', 'Hà Nội', 4, 22, 22, 'Đã kết thúc'),
(9, 5, 'Tour Phú Quốc Đảo Ngọc', 'Khám phá bắc đảo Phú Quốc', 'Ngày 1: Phú Quốc. Khởi hành từ TP Hồ Chí Minh, nhận phòng resort 4 sao, tắm biển Bãi Dài buổi chiều.\r\nNgày 2: Bắc đảo. Tham quan VinWonders, safari Vinpearl, tắm biển Bãi Dài, xem show đêm.\r\nNgày 3: Nam đảo. Khám phá Mũi Ông Đội, Bãi Sao, thưởng thức hải sản tươi, mua sắm tại chợ đêm Phú Quốc.', 6500000.00, '2026-05-03', 'TP. Hồ Chí Minh', 3, 20, 20, 'Đã kết thúc'),
(10, 5, 'Tour Sài Gòn City Tour', 'Tham quan các địa danh nổi tiếng', 'Ngày 1: Tham quan Dinh Độc Lập, Nhà thờ Đức Bà, Bưu điện Trung tâm, Chợ Bến Thành, dạo phố đi bộ Nguyễn Huệ buổi tối.', 1500000.00, '2026-05-06', 'TP. Hồ Chí Minh', 1, 30, 30, 'Đã kết thúc'),
(11, 5, 'Tour Cần Thơ Chợ Nổi', 'Trải nghiệm chợ nổi Cái Răng', 'Ngày 1: Cần Thơ. Khởi hành từ TP Hồ Chí Minh, nhận phòng, buổi chiều tham quan Chùa Ông, Chợ nổi Cái Răng về đêm.\r\nNgày 2: Miền Tây sông nước. Tham quan chợ nổi Cái Răng sáng sớm, vườn trái cây, làng nghề bánh tráng Thuận Hưng, kết thúc chương trình.', 2800000.00, '2026-05-22', 'TP. Hồ Chí Minh', 2, 11, 15, 'Đã kết thúc'),
(12, 5, 'Tour Vũng Tàu Cuối Tuần', 'Nghỉ dưỡng biển Vũng Tàu 2N1Đ', 'Ngày 1: Khởi hành đến tham quan suối nước nóng Bình Châu.\r\nNgày 2: Tham quan Núi Nhỏ + Khu du lịch Hồ Mây + Trở về.', 2200000.00, '2026-06-07', 'TP. Hồ Chí Minh', 2, 18, 20, 'Đã kết thúc'),
(14, 6, 'Sapa - Núi rừng Tây Bắc-', 'Trải nghiệm khí hậu mát lạnh, chinh phục Fansipan', '- Ngày 1: Hà Nội → Sapa → Bản Cát Cát\r\n- Ngày 2: Fansipan → Cáp treo → Check-in\r\n- Ngày 3: Nhà thờ đá → Trở về', 3290000.00, '2026-06-03', 'Hà Nội', 3, 15, 15, 'Đã kết thúc'),
(15, 6, 'Xuyên Việt', 'Hành trình xuyên Việt khám phá 3 miền, phù hợp khách quốc tế và trải nghiệm dài ngày.', '- Ngày 1: Hà Nội → City tour (Lăng Bác, Hồ Gươm)\r\n- Ngày 2: Hà Nội → Huế (máy bay)\r\n- Ngày 3: Huế → Đà Nẵng → Hội An\r\n- Ngày 4: Bà Nà Hills\r\n- Ngày 5: Bay vào TP.HCM\r\n- Ngày 6: Củ Chi → City tour\r\n- Ngày 7: Mua sắm → Kết thúc', 12990000.00, '2026-06-02', 'Hà Nội', 7, 30, 30, 'Đã kết thúc'),
(16, 6, 'Miền Tây - Cần Thơ - Cà Mau - Phú Quốc', 'Trải nghiệm chợ nổi, rừng ngập mặn, cực Nam Tổ quốc.', '- Ngày 1: TP.HCM → Mỹ Tho → Cần Thơ\r\n- Ngày 2: Chợ nổi Cái Răng\r\n- Ngày 3: Cần Thơ → Cà Mau\r\n- Ngày 4: Đất Mũi\r\n- Ngày 5: Trở về', 6490000.00, '2026-06-01', 'TP. Hồ Chí Minh', 5, 18, 18, 'Đã kết thúc'),
(19, 5, 'Hà Nội Ngàn Năm Văn Hiến', 'Khám phá thủ đô Hà Nội – trái tim của Việt Nam với vẻ đẹp giao thoa giữa nét cổ kính và hiện đại. Du khách sẽ được dạo bước qua những con phố nhỏ mang đậm dấu ấn thời gian, thưởng thức các món ăn nổi tiếng và tìm hiểu những giá trị văn hóa đặc sắc của mảnh đất nghìn năm văn hiến. Hành trình mang đến những trải nghiệm đáng nhớ từ Hồ Gươm thơ mộng, Văn Miếu Quốc Tử Giám cổ kính đến không gian nhộn nhịp của Phố Cổ Hà Nội.', 'Ngày 1\r\n- Tham quan Hồ Gươm và cầu Thê Húc.\r\n- Ghé thăm Đền Ngọc Sơn.\r\n- Dạo quanh Phố Cổ Hà Nội bằng xe điện.\r\n- Thưởng thức bún chả Hà Nội.\r\nNgày 2\r\n- Tham quan Văn Miếu Quốc Tử Giám.\r\n- Viếng Lăng Chủ tịch Hồ Chí Minh.\r\n- Khám phá Chùa Một Cột.\r\n- Tham quan Hoàng Thành Thăng Long.\r\nNgày 3\r\n- Mua sắm tại chợ Đồng Xuân.\r\n- Thưởng thức cà phê trứng nổi tiếng.\r\n- Tự do tham quan trước khi khởi hành về.', 3490000.00, '2026-06-17', 'TP. Hồ Chí Minh', 3, 30, 30, 'Đang bán'),
(20, 5, 'Phố Cổ Hội An - Dấu Ấn Thời Gian', 'Khi màn đêm buông xuống, Hội An khoác lên mình chiếc áo lộng lẫy được dệt bằng ánh sáng của hàng ngàn chiếc đèn lồng rực rỡ sắc màu. Tour trong ngày xuất phát từ Đà Nẵng sẽ đưa bạn đi tìm lại sự bình yên trong tâm hồn: trưa thong dong đạp xe giữa làng rau hữu cơ Trà Quế ngát hương, chiều tản bộ qua Chùa Cầu cổ kính, và tối đến sẽ ngồi trên mạn thuyền nhỏ thả những đóa hoa đăng lung linh xuống dòng sông Hoài thơ mộng kèm theo những nguyện ước tốt lành. Hãy đến để sống chậm lại và cảm nhận vẻ đẹp dịu dàng, hoài cổ của di sản văn hóa thế giới này.', 'Ngày 1\r\n- Tham quan Chùa Cầu Nhật Bản.\r\n- Dạo phố cổ Hội An.\r\n- Check-in các con hẻm đèn lồng lung linh.\r\n- Thưởng thức cao lầu và bánh mì Hội An.\r\nNgày 2\r\n- Ghé thăm làng rau Trà Quế, trải nghiệm làm nông dân thực thụ và thưởng thức nước mót thanh mát.\r\n- Tham quan nhà cổ Tấn Ký.\r\n- Trải nghiệm thả đèn hoa đăng trên sông Hoài.\r\nNgày 3\r\n- Mua sắm đặc sản tại chợ Hội An.\r\n- Tham quan Hội quán Phúc Kiến.', 6390000.00, '2026-08-18', 'TP. Hồ Chí Minh', 3, 20, 20, 'Đang bán'),
(21, 5, 'Đà Nẵng - Thành Phố Đáng Sống', 'Đà Nẵng nổi tiếng với những bãi biển đẹp, nền ẩm thực phong phú và nhiều công trình kiến trúc hiện đại. Đây là điểm đến lý tưởng cho những chuyến nghỉ dưỡng kết hợp khám phá văn hóa miền Trung.', 'Ngày 1\r\n- Tắm biển Mỹ Khê.\r\n- Check-in Cầu Rồng.\r\nNgày 2\r\n- Tham quan Bà Nà Hills.\r\n- Trải nghiệm Cầu Vàng nổi tiếng.\r\n- Khám phá Làng Pháp.\r\nNgày 3\r\n- Tham quan Ngũ Hành Sơn.\r\n- Khám phá động Huyền Không.\r\n- Làng đá mỹ nghệ Non Nước.\r\nNgày 4\r\n- Mua sắm đặc sản.\r\n- Tham quan chợ Hàn.', 5290000.00, '2026-07-10', 'TP. Hồ Chí Minh', 4, 35, 35, 'Đang bán'),
(22, 5, 'Nha Trang - Thiên Đường Biển Đảo & Vịnh San Hô', 'Vẫy gọi bạn bằng những bãi cát trắng mịn màng trải dài, làn nước biển trong vắt nhìn thấu tận đáy và những rạn san hô rực rỡ sắc màu dưới lòng đại dương. Tour biển đảo Nha Trang hứa hẹn mang đến một kỳ nghỉ hè bùng nổ năng lượng. Từ những trò chơi cảm giác mạnh trên biển, lặn ngắm san hô bằng ống thở, cho đến những giờ phút thư giãn tuyệt đối tại khu tắm bùn khoáng đẳng cấp, tất cả sẽ tạo nên một chuyến đi không thể nào quên.', '- Ngày 1: Đón ga/sân bay Nha Trang, nhận phòng. Chiều tham quan Tháp Bà Ponagar - kiến trúc Chăm cổ kính và Chùa Long Sơn với tượng Kim Thân Phật Tổ khổng lồ. Tối tự do dạo chợ đêm Nha Trang.\r\n\r\n- Ngày 2: Khởi hành ra bến cảng, đi cano cao tốc ra Vịnh San Hô, trải nghiệm lặn biển ngắm san hô và cá biển. Trưa ăn trưa tại Làng Chài với hệ thống bè nuôi hải sản. Chiều qua đảo Hòn Tằm trải nghiệm gói tắm bùn khoáng nóng và thư giãn bên hồ bơi vô cực hướng vịnh.\r\n\r\n- Ngày 3: Sáng check-in Viện Hải dương học Nha Trang, ngắm nhìn hàng ngàn loài sinh vật biển lạ mắt. Chiều tự do mua sắm đặc sản mực rim, yến sào tại Chợ Đầm trước khi tiễn khách.', 2900000.00, '2026-07-09', 'TP. Hồ Chí Minh', 3, 34, 35, 'Đang bán'),
(23, 6, 'Ninh Bình - Tuyệt Tác \"Hạ Long Trên Cạn\"', 'Ninh Bình sở hữu vẻ đẹp non nước hữu tình khiến bất kỳ ai một lần đặt chân đến cũng phải trầm trồ thán phục. Chuyến đi này sẽ đưa bạn lạc vào cõi Phật thanh tịnh tại chùa Bái Đính - ngôi chùa sở hữu nhiều kỷ lục nhất Việt Nam, sau đó ngồi thuyền nan xuôi dòng dòng sông sào khê khám phá quần thể hang động Tràng An huyền ảo. Điểm nhấn của tour là thử thách chinh phục đỉnh Hang Múa ngắm nhìn toàn cảnh thung lũng lúa Tam Cốc đẹp như một bức tranh thủy mặc.', '- Ngày 1: Xe đón khách từ Hà Nội đi Ninh Bình. Sáng chiêm bái Chùa Bái Đính (ngắm tượng Phật bằng đồng nặng 100 tấn, hành lang La Hán). Chiều nhận phòng khách sạn, di chuyển đi chinh phục 486 bậc đá đỉnh Hang Múa, check-in tháp nhọn và ngắm hoàng hôn buông xuống dòng sông Ngô Đồng.\r\n\r\n- Ngày 2: Sáng trải nghiệm tuyến thuyền nan Tràng An (đi qua các hang tối, hang sáng, Đền Trình và phim trường King Kong cũ). Trưa thưởng thức đặc sản cơm cháy, thịt dê núi Ninh Bình. Chiều tham quan Cố đô Hoa Lư trước khi xe đưa đoàn về lại Hà Nội.', 2300000.00, '2026-06-06', 'Hà Nội', 2, 21, 22, 'Tạm dừng'),
(24, 6, 'Phú Quốc - Thiên Đường Nắng Vàng Biển Đảo', 'Đảo ngọc Phú Quốc luôn là điểm hẹn ước mơ của mọi tín đồ du lịch biển với những bãi biển thuộc hàng đẹp nhất thế giới. Trải nghiệm tuyến cáp treo vượt biển dài nhất thế giới sang hòn Thơm, lặn ngắm san hô tại các hòn đảo hoang sơ phía Nam, và check-in thị trấn Hoàng Hôn mang đậm phong cách Địa Trung Hải đầy lãng mạn. Phú Quốc không chỉ có thiên nhiên tuyệt sắc mà còn mang đến những dịch vụ nghỉ dưỡng cao cấp xứng tầm, giúp bạn có một kỳ nghỉ hoàn hảo từng khoảnh khắc.', 'Ngày 1: Xe đón sân bay Phú Quốc đưa về resort. Chiều check-in Thị trấn Địa Trung Hải Sunset Town, ngắm hoàng hôn tuyệt mỹ bên Cầu Hôn (Kiss Bridge). Tối tự do khám phá chợ đêm Grand World \"thành phố không ngủ\".\r\n\r\nNgày 2: Hành trình cano khám phá 3 đảo phía Nam: Hòn Mây Rút, Hòn Gầm Ghì, Hòn Móng Tay. Trải nghiệm lặn ngắm san hô tự nhiên, quay video flycam miễn phí trên bãi cát. Chiều trải nghiệm Cáp treo Hòn Thơm và quậy đục nước tại công viên nước Aquatopia.\r\n\r\nNgày 3: Sáng tham quan VinWonders hoặc Vinpearl Safari (vườn thú bán hoang dã lớn nhất Việt Nam). Chiều tắm biển tại Bãi Sao với bãi cát trắng mịn như kem và hàng dừa nghiêng soi bóng.\r\n\r\nNgày 4: Sáng ghé thăm Nhà thùng nước mắm truyền thống, vườn tiêu Phú Quốc. Mua sắm đặc sản ngọc trai chất lượng cao trước khi xe tiễn ra sân bay.', 6500000.00, '2026-07-04', 'Hà Nội', 4, 40, 40, 'Đang bán'),
(25, 6, 'Sapa - Nơi Gặp Gỡ Đất Trời & Chinh Phục Fansipan', 'Sapa quyến rũ du khách bởi vẻ đẹp mờ ảo trong sương, những thửa ruộng bậc thang uốn lượn như những nấc thang lên thiên đường và nét văn hóa độc đáo của đồng bào các dân tộc thiểu số vùng cao. Điểm nhấn không thể bỏ qua chính là hành trình chạm tay vào cột mốc \"Nóc nhà Đông Dương\" - đỉnh Fansipan kiêu hãnh ở độ cao 3,143m. Hãy đến để cảm nhận cái se lạnh của phố núi, thưởng thức ngô nướng bếp than hồng và săn những biển mây trắng bồng bềnh ôm lấy núi đồi!', 'Ngày 1: Xe giường nằm cao cấp đưa đoàn từ Hà Nội lên Sapa. Chiều đi bộ tham quan Bản Cát Cát của người H\'Mông, check-in con suối Mường Hoa, những guồng nước khổng lồ và thuê trang phục dân tộc chụp ảnh. Tối dạo phố đi bộ, check-in Nhà thờ đá Sapa cổ kính.\r\n\r\nNgày 2: Sáng di chuyển ra ga cáp treo, chinh phục đỉnh Fansipan bằng hệ thống cáp treo hiện đại và tàu hỏa leo núi. Chiêm bái quần thể tâm linh Ga Fansipan mờ ảo trong sương. Chiều tự do check-in đèo Ô Quy Hồ - một trong tứ đại đỉnh đèo vùng Tây Bắc.\r\n\r\nNgày 3: Sáng chinh phục Núi Hàm Rồng, ngắm Vườn Lan, Cổng Trời và toàn cảnh thị trấn Sapa từ trên cao. Trưa thưởng thức lẩu cá hồi, cá tầm đặc sản trước khi lên xe về lại Hà Nội.', 3800000.00, '2026-06-06', 'Hà Nội', 3, 27, 28, 'Đang bán'),
(27, 6, 'ádasd', 'cádcasdc', 'ádcasdcasdca', 123.00, '2054-02-23', 'Hà Nội', 3, 2, 2, 'Từ chối'),
(29, 6, 'Hành Trình Lịch Sử Hào Hùng Củ Chi - Cao Đài', '- Hãy tạm xa những trung tâm thương mại lộng lẫy để tìm về một \"mê cung dưới lòng đất\" huyền thoại đã làm kinh ngạc cả thế giới - Địa đạo Củ Chi. Hành trình này sẽ giúp bạn hiểu rõ hơn về ý chí kiên cường và sự sáng tạo phi thường của quân và dân ta trong thời kỳ chiến tranh kháng chiến. Trải nghiệm khom mình bước đi trong lòng địa đạo hẹp, thưởng thức củ mài chấm muối vừng bên bếp Hoàng Cầm sẽ mang lại những cảm xúc vô cùng thiêng liêng và tự hào.\r\n\r\n- Đưa bạn đi qua những công trình kiến trúc mang đậm dấu ấn Pháp cổ kính, lướt qua những tòa nhà chọc trời tráng lệ, và trải nghiệm nhịp sống hối hả từ những quán cà phê bệt vỉa hè cho đến du thuyền hạng sang trên dòng sông Sài Gòn lộng gió.', 'Ngày 1: Check-in Nhà thờ Đức Bà, Bưu điện Thành phố với kiến trúc Gothic độc đáo. Khởi hành đi Củ Chi. Đến nơi, đoàn xem thước phim tư liệu ngắn, sau đó theo chân hướng dẫn viên khám phá hệ thống công sự, hầm chông, hầm hội họp ngầm dưới lòng đất. Trải nghiệm chui hầm địa đạo thực tế. Thử tài bắn súng tại trường bắn (chi phí tự túc). Thưởng thức món khoai mì (củ mài) luộc chấm muối mè tại bếp Hoàng Cầm khói không cay. 14h00 xe đưa đoàn trở lại dạo quanh Chợ Bến Thành mua sắm, check-in bảo tàng Mỹ Thuật. 18h00 lên du thuyền tại bến Bạch Đằng, dùng bữa tối lãng mạn và ngắm toàn cảnh thành phố lung linh ánh đèn từ sông Sài Gòn\r\n\r\nNgày 2: Di chuyển tham quan Dinh Độc Lập - nơi lưu giữ những dấu ấn lịch sử trọng đại. Trưa thưởng thức cơm tấm Sài Gòn chính gốc trước khi lên xe về lại Hà Nội.', 1450000.00, '2026-07-07', 'Hà Nội', 2, 25, 25, 'Đang bán'),
(30, 6, 'Vũng Tàu - Biển Xanh Vẫy Gọi & Gió Lộng Núi Cao', 'Vũng Tàu luôn là điểm trốn nóng lý tưởng hàng đầu với những bãi biển lộng gió và cung đường ven biển tuyệt đẹp. Không chỉ được tự do vẫy vùng trong làn nước mát tại Bãi Sau, chuyến đi còn đưa bạn chinh phục ngọn núi Nhỏ để đứng dưới chân tượng Chúa Kitô Vua khổng lồ ngắm trọn vẹn toàn cảnh đại dương xanh ngắt bao la. Thưởng thức bánh khọt giòn rụm bên bờ biển và hít hà hương vị mặn mòi của biển cả sẽ giúp bạn thổi bay mọi mệt mỏi của những ngày làm việc vất vả.', 'Ngày 1: Xuất phát từ TP.HCM đi Vũng Tàu. Đến nơi nhận phòng, tự do tắm biển Bãi Sau. Chiều tham quan dinh thự Bạch Dinh cổ kính mang kiến trúc Pháp, ngắm hàng hoa sứ cổ thụ. Tối thưởng thức bánh khọt Cô Ba Vũng Tàu hoặc hải sản tại chợ đêm.\r\n\r\nNgày 2: Sáng sớm chinh phục hơn 800 bậc đá lên Tượng Chúa Kitô Vua dang tay trên đỉnh núi Nhỏ, ngắm trọn mũi Nghinh Phong từ trên cao. Tiếp tục check-in Ngọn Hải Đăng Vũng Tàu cổ xưa nhất Việt Nam trước khi lên xe về lại TP.HCM.', 1950000.00, '2026-07-13', 'Hà Nội', 2, 27, 27, 'Chờ duyệt'),
(31, 5, 'mbmbnvnvnvc', 'byebye', 'hihi', 123123123.00, '2027-02-12', 'Hà Nội', 15, 2, 2, 'Chờ duyệt'),
(32, 5, 'Xuyên Việt', 'Chào mừng quý khách đến với hành trình đặc biệt nhất trong đời – Tour Xuyên Việt 15 ngày 14 đêm. Đây không chỉ là một chuyến du lịch, mà là một cuốn phim sống động đưa bạn đi qua mọi cung bậc cảm xúc, từ vùng núi cao Tây Bắc hùng vĩ, qua dải đất miền Trung đầy nắng gió cổ kính, đến với vùng sông nước miền Tây Nam Bộ trù phú và hiền hòa.\r\n\r\nNhững trải nghiệm vượt trội trong hành trình:\r\n- Khám phá Kỳ quan: Vịnh Hạ Long – Di sản thiên nhiên thế giới; Quần thể danh thắng Tràng An; Động Phong Nha kỳ vĩ.\r\n- Hoài niệm lịch sử: Thăm Cố đô Huế trầm mặc, Phố cổ Hội An lung linh đèn lồng, và Địa đạo Củ Chi huyền thoại.\r\n- Tận hưởng thiên nhiên: Đón bình minh trên biển Nha Trang, ngắm hoàng hôn buông xuống trên những cồn cát Mũi Né và trải nghiệm cuộc sống sông nước tại Chợ nổi Cái Răng (Cần Thơ).\r\n- Ẩm thực bản địa độc đáo: Thưởng thức Phở Hà Nội, Bún bò Huế, Cao lầu Hội An, Hải sản Nha Trang và lẩu mắm miền Tây chuẩn vị.\r\n\r\nTour đã bao gồm trọn gói vé máy bay, xe du lịch đời mới limousine, hướng dẫn viên chuyên nghiệp suốt tuyến và lưu trú tại hệ thống khách sạn/resort 3-4 sao tiêu chuẩn quốc tế. Hãy để chúng tôi đồng hành cùng bạn ghi lại những khoảnh khắc thanh xuân rực rỡ nhất trên dải đất hình chữ S!', 'Ngày 1: Hà Nội – Ninh Bình (Tràng An – Bái Đính) – Thanh Hóa (Ăn Trưa, Tối)\r\n\r\nSáng: Xe và HDV đón quý khách tại điểm hẹn tại Hà Nội, khởi hành đi Ninh Bình. Viếng chùa Bái Đính – ngôi chùa lớn với nhiều kỷ lục Quốc gia.\r\n\r\nChiều: Khám phá Quần thể danh thắng Tràng An, ngồi thuyền chèo qua các hang động xuyên thủy tự nhiên. Sau đó di chuyển vào Thanh Hóa nhận phòng nghỉ ngơi.\r\n\r\nTối: Tự do dạo biển Sầm Sơn hoặc thưởng thức đặc sản nem chua Thanh Hóa.\r\n\r\nNgày 2: Thanh Hóa – Nghệ An (Quê Bác) – Quảng Bình (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Khởi hành đi Nghệ An. Ghé thăm Làng Sen (Nam Đàn) – Quê hương của Chủ tịch Hồ Chí Minh, tham quan ngôi nhà mái tranh đơn sơ nơi Bác đã gắn bó thời niên thiếu.\r\n\r\nChiều: Tiếp tục hành trình xuyên Việt vào Quảng Bình. Ghé dâng hương tại Ngã ba Đồng Lộc (Hà Tĩnh).\r\n\r\nTối: Đến Đồng Hới (Quảng Bình), nhận phòng khách sạn, tự do dạo biển Nhật Lệ về đêm.\r\n\r\nNgày 3: Quảng Bình (Phong Nha) – Vĩ Tuyến 17 – Cố Đô Huế (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Ngồi thuyền ngược dòng sông Son hành trình khám phá Động Phong Nha kỳ vĩ với hệ thống thạch nhũ tráng lệ.\r\n\r\nChiều: Di chuyển vào Quảng Trị, tham quan Di tích quốc gia đặc biệt Đôi bờ Hiền Lương – Sông Bến Hải (Vĩ tuyến 17 lịch sử). Sau đó thẳng tiến vào Thừa Thiên Huế.\r\n\r\nTối: Đến Huế, nhận phòng. Ngồi thuyền rồng thưởng thức ca Huế trên Sông Hương và thả hoa đăng.\r\n\r\nNgày 4: Đại Nội Huế – Đà Nẵng (Bán Đảo Sơn Trà) – Hội An (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Thăm Đại Nội Huế (Ngọ Môn, Điện Thái Hòa, Tử Cấm Thành) và Chùa Thiên Mụ cổ kính bên dòng sông Hương.\r\n\r\nChiều: Khởi hành đi Đà Nẵng qua hầm Hải Vân. Ghé check-in Bán đảo Sơn Trà, viếng Linh Ứng Tự (nơi có tượng Phật Bà cao 67m). Tiến về Phố cổ Hội An (Quảng Nam).\r\n\r\nTối: Đi bộ ngắm Phố cổ Hội An lung linh đèn lồng, thăm Chùa Cầu, thưởng thức món ăn đặc sản Cao Lầu.\r\n\r\nNgày 5: Hội An – Quy Nhơn (Gành Đá Đĩa Phú Yên) (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Rời Hội An, xe chạy dọc duyên hải miền Trung hướng về Bình Định và Phú Yên.\r\n\r\nChiều: Ghé thăm Gành Đá Đĩa (Phú Yên) – một kiệt tác địa chất độc nhất vô nhị với các khối đá hình lăng trụ xếp chồng lên nhau bên bờ biển.\r\n\r\nTối: Quay lại thành phố biển Quy Nhơn (Bình Định) nhận phòng, tự do ăn hải sản.\r\n\r\nNgày 6: Quy Nhơn (Eo Gió) – Nha Trang (Tháp Bà Ponagar) (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Check-in Eo Gió (Quy Nhơn) – nơi đón bình minh đẹp nhất Việt Nam. Sau đó khởi hành đi Nha Trang (Khánh Hòa).\r\n\r\nChiều: Đến Nha Trang, tham quan Tháp Bà Ponagar – công trình kiến trúc Chăm cổ đặc sắc và linh thiêng bậc nhất miền Trung.\r\n\r\nTối: Tự do dạo biển Trần Phú, thưởng thức nem nướng Ninh Hòa hoặc bún sứa Nha Trang.\r\n\r\nNgày 7: Nha Trang – Mũi Né (Phan Thiết) – Đồi Cát Bay (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Tạm biệt Nha Trang, xe đưa đoàn đi qua cung đường biển Ninh Chữ hướng về Phan Thiết (Bình Thuận).\r\n\r\nChiều: Khám phá Đồi Cát Bay (Mũi Né), trải nghiệm trượt cát mạo hiểm và chụp ảnh check-in những chiếc xe mui trần rực rỡ bên bờ biển hoang sơ.\r\n\r\nTối: Nghỉ đêm tại Resort Mũi Né, thưởng thức hải sản tươi sống giá rẻ tại bờ kè.\r\n\r\nNgày 8: Mũi Né – TP. Hồ Chí Minh (Hòn Ngọc Viễn Đông) (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Khởi hành đi TP. Hồ Chí Minh theo đường cao tốc.\r\n\r\nChiều: Tham quan các công trình biểu tượng của thành phố: Dinh Độc Lập, Nhà thờ Đức Bà, Bưu điện Thành phố và mua sắm tại Chợ Bến Thành.\r\n\r\nTối: Khám phá Phố đi bộ Nguyễn Huệ sầm uất hoặc ngồi du thuyền ngắm cảnh sông Sài Gòn lung linh.\r\n\r\nNgày 9: TP.HCM – Tiền Giang (Mỹ Tho) – Tây Đô Cần Thơ (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Xuống vùng sông nước Miền Tây. Đến Mỹ Tho (Tiền Giang), lên thuyền tham quan các cù lao, trải nghiệm chèo xuồng ba lá trong rạch dừa nước, thưởng thức trái cây miệt vườn và nghe đờn ca tài tử Nam Bộ.\r\n\r\nChiều: Xe đưa đoàn di chuyển xuyên qua cầu Cần Thơ để đến với mảnh đất Tây Đô sầm uất.\r\n\r\nTối: Khám phá Bến Ninh Kiều, dạo chợ đêm Cần Thơ hoặc ăn tối trên du thuyền Cần Thơ.\r\n\r\nNgày 10: Chợ Nổi Cái Răng – Cột Mốc Đất Mũi Cà Mau (Ăn Sáng, Trưa, Tối)\r\n\r\n05:00 Sáng: Xuống bến tàu tham quan Chợ nổi Cái Răng – nét văn hóa giao thương độc đáo trên sông nước của người dân Nam Bộ.\r\n\r\nTrưa: Khởi hành đi Cà Mau – điểm cuối cùng cực Nam trên bản đồ Tổ Quốc.\r\n\r\nChiều: Check-in Cột mốc tọa độ quốc gia GPS 0001, ngắm biểu tượng Mũi Tàu Cà Mau hướng ra biển lớn.\r\n\r\nTối: Nghỉ đêm tại TP. Cà Mau.\r\n\r\nNgày 11: Cà Mau – Bạc Liêu (Nhà Công Tử) – Buôn Ma Thuột (Tây Nguyên) (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Rời Cà Mau, ghé Bạc Liêu tham quan Nhà Công tử Bạc Liêu – nghe kể về những giai thoại giàu có nức tiếng một thời.\r\n\r\nChiều: Đoạn đường chuyển hướng đặc biệt: Xe bắt đầu di chuyển lên vùng cao nguyên đất đỏ dọc theo quốc lộ 14 hướng về Buôn Ma Thuột (Đắk Lắk).\r\n\r\nTối: Đến Buôn Ma Thuột, thưởng thức hương vị cà phê Ban Mê nồng nàn trong không khí se lạnh.\r\n\r\nNgày 12: Buôn Ma Thuột (Buôn Đôn) – Gia Lai (Biển Hồ T’Nưng) (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Tham quan Bản Đôn (Buôn Đôn) – quê hương của nghề săn bắt và thuần dưỡng voi rừng, trải nghiệm đi cầu tre qua sông Serepôk.\r\n\r\nChiều: Khởi hành đi Pleiku (Gia Lai). Ghé thăm Biển Hồ T\'Nưng – nơi được mệnh danh là \"Đôi mắt Pleiku\" xanh ngắt kỳ ảo vốn là miệng núi lửa đã tắt.\r\n\r\nTối: Nghỉ đêm tại Pleiku, thưởng thức món phở hai tô (phở khô Gia Lai).\r\n\r\nNgày 13: Gia Lai – Kon Tum (Nhà Thờ Gỗ) – Đà Nẵng / Quảng Nam (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Di chuyển sang Kon Tum, viếng thăm Nhà thờ Gỗ Kon Tum – công trình kiến trúc độc bản kết hợp hoàn hảo giữa kiến trúc Roman và nhà sàn truyền thống Ba Na.\r\n\r\nChiều: Đổ đèo dọc theo tuyến đường Trường Sơn huyền thoại để đi xuống lại vùng duyên hải, nghỉ đêm tại khu vực Quảng Nam / Đà Nẵng.\r\n\r\nTối: Tự do dạo chơi, nghỉ ngơi phục hồi sức khỏe sau chặng đường dài.\r\n\r\nNgày 14: Đà Nẵng – Vịnh Lăng Cô – Quảng Trị (Địa Đạo Vịnh Mốc) – Hà Tĩnh (Ăn Sáng, Trưa, Tối)\r\n\r\nSáng: Khởi hành ngược ra Bắc. Ghé check-in và ăn trưa bên Vịnh Lăng Cô (Thừa Thiên Huế) – một trong những vịnh biển đẹp nhất thế giới.\r\n\r\nChiều: Ra Quảng Trị, khám phá Địa đạo Vịnh Mốc – một \"thành phố ngầm\" huyền thoại trong lòng đất của quân và dân ta thời chiến tranh. Sau đó di chuyển ra Hà Tĩnh nhận phòng.\r\n\r\nTối: Nghỉ ngơi tại Hà Tĩnh, thưởng thức đặc sản kẹo cu đơ, chè xanh.\r\n\r\nNgày 15: Hà Tĩnh – Thanh Hóa – Trở Về Hà Nội (Kết Thúc Hành Trình) (Ăn Sáng, Trưa)\r\n\r\nSáng: Xe đưa đoàn xuất phát chặng cuối cùng, đi qua Nghệ An, Thanh Hóa.\r\n\r\nTrưa: Dừng chân ăn trưa đặc sản cơm cháy, thịt dê tại Ninh Bình hoặc mua đặc sản dứa, nem chua dọc đường làm quà.\r\n\r\nChiều: Xe về tới điểm hẹn ban đầu tại Thủ đô Hà Nội. Kết thúc thành công mỹ mãn hành trình Xuyên Việt vòng tròn 15 ngày 14 đêm.', 20000000.00, '2026-06-10', 'Hà Nội', 15, 12, 12, 'Đang bán'),
(33, 5, 'Hạ Long - Khám Phá Đảo Ngọc Tuần Châu', 'Sự kết hợp hoàn hảo giữa hành trình khám phá thiên nhiên kỳ vĩ và thế giới giải trí đỉnh cao tại tổ hợp Sun World Hạ Long Complex. Tour du lịch này cực kỳ phù hợp cho các gia đình và nhóm bạn trẻ năng động, muốn vừa có những bức ảnh check-in sống ảo triệu like trên cáp treo Nữ Hoàng vượt biển, vừa muốn thả mình thư giãn trên những con tàu truyền thống len lỏi qua các hòn đảo đá mang hình thù độc đáo.', 'Ngày 1: Di chuyển đến Hạ Long, nhận phòng khách sạn tại khu vực Bãi Cháy. Chiều tự do vui chơi tại Công viên Rồng (Dragon Park) với các trò chơi cảm giác mạnh hàng đầu châu Á. Tối dạo chợ đêm ven biển và thưởng thức chả mực giã tay đặc sản.\r\n\r\nNgày 2: Sáng lên tàu tham quan Vịnh Hạ Long tuyến 4 tiếng: đi qua Hòn Gà Chọi, Hòn Đỉnh Hương, khám phá Động Thiên Cung nguy nga. Chiều trải nghiệm Cáp treo Nữ Hoàng sang khu đồi Huyền Bí, check-in Vườn Nhật Bản và ngắm hoàng hôn Hạ Long.\r\n\r\nNgày 3: Tự do tắm biển Bãi Cháy, check-in phố cổ Sun World mô phỏng Hội An - Hà Nội cũ. Trưa thu dọn hành lý, mua sắm quà lưu niệm và khởi hành về lại điểm xuất phát.', 3200000.00, '2026-07-12', 'TP. Hồ Chí Minh', 3, 35, 35, 'Đang bán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_anh`
--

CREATE TABLE `tour_anh` (
  `maAnh` int(10) UNSIGNED NOT NULL,
  `maTour` int(10) UNSIGNED NOT NULL,
  `duongDan` varchar(255) NOT NULL,
  `lamAnhChinh` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_anh`
--

INSERT INTO `tour_anh` (`maAnh`, `maTour`, `duongDan`, `lamAnhChinh`) VALUES
(1, 1, 'assets/img/tours/sapa.jpg', 1),
(2, 2, 'assets/img/tours/hanoi.jpg', 1),
(3, 3, 'assets/img/tours/halong.jpg', 1),
(4, 4, 'assets/img/tours/ninhbinh.jpg', 1),
(5, 5, 'assets/img/tours/danang.jpg', 1),
(6, 6, 'assets/img/tours/hoian.jpg', 1),
(7, 7, 'assets/img/tours/hue.jpg', 1),
(8, 8, 'assets/img/tours/nhatrang.jpg', 1),
(9, 9, 'assets/img/tours/phuquoc.jpg', 1),
(10, 10, 'assets/img/tours/saigon.jpg', 1),
(11, 11, 'assets/img/tours/cantho.jpg', 1),
(12, 12, 'assets/img/tours/vungtau.jpg', 1),
(14, 14, 'assets/img/tours/tour_14_main_1777539329.jpg', 1),
(15, 14, 'assets/img/tours/tour_14_sub_1777539329_0.jpg', 0),
(16, 14, 'assets/img/tours/tour_14_sub_1777539329_1.jpg', 0),
(17, 15, 'assets/img/tours/tour_15_main_1777539621.jpg', 1),
(18, 15, 'assets/img/tours/tour_15_sub_1777539621_0.jpg', 0),
(19, 15, 'assets/img/tours/tour_15_sub_1777539621_1.jpg', 0),
(20, 15, 'assets/img/tours/tour_15_sub_1777539621_2.jpg', 0),
(21, 15, 'assets/img/tours/tour_15_sub_1777539621_3.jpg', 0),
(22, 16, 'assets/img/tours/tour_16_main_1777540133.jpg', 1),
(23, 16, 'assets/img/tours/tour_16_sub_1777540133_0.jpg', 0),
(24, 16, 'assets/img/tours/tour_16_sub_1777540133_1.jpg', 0),
(25, 16, 'assets/img/tours/tour_16_sub_1777540133_2.jpg', 0),
(26, 16, 'assets/img/tours/tour_16_sub_1777540133_3.jpg', 0),
(31, 19, 'assets/img/tours/tour_19_main_1780586246.jpg', 1),
(32, 19, 'assets/img/tours/tour_19_sub_1780586246_0.jpg', 0),
(33, 19, 'assets/img/tours/tour_19_sub_1780586246_1.jpg', 0),
(34, 20, 'assets/img/tours/tour_20_main_1780586474.jpg', 1),
(35, 20, 'assets/img/tours/tour_20_sub_1780586474_0.jpg', 0),
(36, 21, 'assets/img/tours/tour_21_main_1780586887.jpg', 1),
(37, 21, 'assets/img/tours/tour_21_sub_1780586887_0.jpg', 0),
(38, 21, 'assets/img/tours/tour_21_sub_1780586887_1.jpg', 0),
(39, 21, 'assets/img/tours/tour_21_sub_1780586887_2.jpg', 0),
(40, 22, 'assets/img/tours/tour_22_main_1780587121.jpg', 1),
(41, 22, 'assets/img/tours/tour_22_sub_1780587121_0.jpg', 0),
(42, 22, 'assets/img/tours/tour_22_sub_1780587121_1.jpg', 0),
(43, 23, 'assets/img/tours/tour_23_main_1780587290.jpg', 1),
(44, 23, 'assets/img/tours/tour_23_sub_1780587290_0.jpg', 0),
(45, 23, 'assets/img/tours/tour_23_sub_1780587290_1.jpg', 0),
(46, 24, 'assets/img/tours/tour_24_main_1780587386.jpg', 1),
(47, 25, 'assets/img/tours/tour_25_main_1780587472.jpg', 1),
(48, 25, 'assets/img/tours/tour_25_sub_1780587472_0.jpg', 0),
(49, 25, 'assets/img/tours/tour_25_sub_1780587472_1.jpg', 0),
(50, 25, 'assets/img/tours/tour_25_sub_1780587472_2.jpg', 0),
(52, 27, 'assets/img/tours/tour_27_main_1780588482.jpg', 1),
(54, 29, 'assets/img/tours/tour_29_main_1780589979.jpg', 1),
(55, 29, 'assets/img/tours/tour_29_sub_1780589979_0.jpg', 0),
(56, 30, 'assets/img/tours/tour_30_main_1780590107.jpg', 1),
(57, 30, 'assets/img/tours/tour_30_sub_1780590107_0.jpg', 0),
(58, 31, 'assets/img/tours/tour_31_main_1780591231.jpg', 1),
(59, 32, 'assets/img/tours/tour_32_main_1780591626.jpg', 1),
(60, 32, 'assets/img/tours/tour_32_sub_1780591626_0.jpg', 0),
(61, 32, 'assets/img/tours/tour_32_sub_1780591626_1.jpg', 0),
(62, 32, 'assets/img/tours/tour_32_sub_1780591626_2.jpg', 0),
(63, 33, 'assets/img/tours/tour_33_main_1780591914.jpg', 1),
(64, 33, 'assets/img/tours/tour_33_sub_1780591914_0.jpg', 0),
(65, 33, 'assets/img/tours/tour_33_sub_1780591914_1.jpg', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_diemden`
--

CREATE TABLE `tour_diemden` (
  `maDiemDen` int(10) UNSIGNED NOT NULL COMMENT 'Vừa là PK, vừa là FK',
  `maTour` int(10) UNSIGNED NOT NULL COMMENT 'Vừa là PK, vừa là FK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_diemden`
--

INSERT INTO `tour_diemden` (`maDiemDen`, `maTour`) VALUES
(1, 1),
(1, 14),
(1, 25),
(2, 2),
(2, 19),
(2, 27),
(2, 31),
(2, 32),
(3, 3),
(3, 33),
(4, 4),
(4, 23),
(5, 5),
(5, 21),
(6, 6),
(6, 20),
(7, 7),
(8, 8),
(8, 22),
(9, 9),
(9, 16),
(9, 24),
(10, 10),
(10, 15),
(10, 29),
(11, 11),
(12, 12),
(12, 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `maND` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matKhau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `soDienThoai` varchar(10) NOT NULL,
  `vaiTro` enum('Quản trị viên','Khách hàng','Nhà phân phối tour') NOT NULL DEFAULT 'Khách hàng',
  `trangThai` enum('Hoạt động','Vô hiệu hóa') NOT NULL DEFAULT 'Hoạt động',
  `diaChi` varchar(255) DEFAULT NULL,
  `tenCongTy` varchar(255) DEFAULT NULL,
  `diaChiCongTy` varchar(255) DEFAULT NULL,
  `tyLeHoaHong` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`maND`, `email`, `matKhau`, `hoTen`, `soDienThoai`, `vaiTro`, `trangThai`, `diaChi`, `tenCongTy`, `diaChiCongTy`, `tyLeHoaHong`) VALUES
(1, 'cakien197@gmail.com', '$2y$10$qt/A5V0k08HMoLG9YmQyv.oAD3oE4n1zKnEcgWfNVmQ.4c12ej8d.', 'Chu Anh Kiên', '0971518927', 'Khách hàng', 'Hoạt động', 'Thạch Thất - Hà Nội', NULL, NULL, NULL),
(2, 'admin@gmail.com', '$2y$10$cJm9tFLMTvldxBwfhCUCGOHveuN8LmfTxQMhPG3HNcBWAs/2z3.x6', 'ADMIN', '0123456789', 'Quản trị viên', 'Hoạt động', '', '', '', NULL),
(4, 'kh1@gmail.com', '$2y$10$YuVkWW0DxZO/j7rmA5lHduTr/eLkhDDEEg0.Wbzv/JVK/eknFmbsG', 'Khách hàng 1', '0987654321', 'Khách hàng', 'Hoạt động', 'Thạch Thất - Hà Nội', '', '', NULL),
(5, 'npp1@gmail.com', '$2y$10$4yEdd/8Ne5BCYhiIEqYG.uwMNjrP1VHK6FtXHPGYi/sjQxgfDpF3i', 'Nhà phân phối tour 1', '0147953268', 'Nhà phân phối tour', 'Hoạt động', '', 'Bon Be La Nha', 'Nay Đây - Mai Đó - Hà Nội', 85.00),
(6, 'npp2@gmail.com', '$2y$10$jgP4/3hUFiZe1Djyexxg4OJNBQCdt1SJ7e4honf22R91t2h7lbbaO', 'Nhà phân phối tour 2', '0123456789', 'Nhà phân phối tour', 'Hoạt động', '', 'Vuot Ngan Chong Gai', 'Chỗ Nọ - Chỗ Kia - TP Hồ Chí Minh', 85.00);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baocao`
--
ALTER TABLE `baocao`
  ADD PRIMARY KEY (`maBaoCao`),
  ADD KEY `maND` (`maND`),
  ADD KEY `maTour` (`maTour`);

--
-- Chỉ mục cho bảng `diemden`
--
ALTER TABLE `diemden`
  ADD PRIMARY KEY (`maDiemDen`);

--
-- Chỉ mục cho bảng `dondat`
--
ALTER TABLE `dondat`
  ADD PRIMARY KEY (`maDon`),
  ADD KEY `maND` (`maND`),
  ADD KEY `maTour` (`maTour`);

--
-- Chỉ mục cho bảng `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD PRIMARY KEY (`maPhanHoi`),
  ADD KEY `maND` (`maND`),
  ADD KEY `maBaoCao` (`maBaoCao`);

--
-- Chỉ mục cho bảng `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`maTour`),
  ADD KEY `maND` (`maND`);

--
-- Chỉ mục cho bảng `tour_anh`
--
ALTER TABLE `tour_anh`
  ADD PRIMARY KEY (`maAnh`),
  ADD KEY `maTour` (`maTour`);

--
-- Chỉ mục cho bảng `tour_diemden`
--
ALTER TABLE `tour_diemden`
  ADD PRIMARY KEY (`maDiemDen`,`maTour`),
  ADD KEY `maTour` (`maTour`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`maND`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baocao`
--
ALTER TABLE `baocao`
  MODIFY `maBaoCao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `diemden`
--
ALTER TABLE `diemden`
  MODIFY `maDiemDen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `dondat`
--
ALTER TABLE `dondat`
  MODIFY `maDon` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `phanhoi`
--
ALTER TABLE `phanhoi`
  MODIFY `maPhanHoi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `tour`
--
ALTER TABLE `tour`
  MODIFY `maTour` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `tour_anh`
--
ALTER TABLE `tour_anh`
  MODIFY `maAnh` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `maND` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baocao`
--
ALTER TABLE `baocao`
  ADD CONSTRAINT `baocao_ibfk_1` FOREIGN KEY (`maND`) REFERENCES `user` (`maND`),
  ADD CONSTRAINT `baocao_ibfk_2` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`);

--
-- Các ràng buộc cho bảng `dondat`
--
ALTER TABLE `dondat`
  ADD CONSTRAINT `dondat_ibfk_1` FOREIGN KEY (`maND`) REFERENCES `user` (`maND`),
  ADD CONSTRAINT `dondat_ibfk_2` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`);

--
-- Các ràng buộc cho bảng `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD CONSTRAINT `phanhoi_ibfk_1` FOREIGN KEY (`maND`) REFERENCES `user` (`maND`),
  ADD CONSTRAINT `phanhoi_ibfk_2` FOREIGN KEY (`maBaoCao`) REFERENCES `baocao` (`maBaoCao`);

--
-- Các ràng buộc cho bảng `tour_anh`
--
ALTER TABLE `tour_anh`
  ADD CONSTRAINT `tour_anh_ibfk_1` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`);

--
-- Các ràng buộc cho bảng `tour_diemden`
--
ALTER TABLE `tour_diemden`
  ADD CONSTRAINT `tour_diemden_ibfk_1` FOREIGN KEY (`maDiemDen`) REFERENCES `diemden` (`maDiemDen`),
  ADD CONSTRAINT `tour_diemden_ibfk_2` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`);

DELIMITER $$
--
-- Sự kiện
--
CREATE DEFINER=`root`@`localhost` EVENT `xoa_don_qua_han` ON SCHEDULE EVERY 1 MINUTE STARTS '2026-04-16 21:04:29' ON COMPLETION PRESERVE ENABLE DO BEGIN
    -- Hoàn lại chỗ trống cho tour
    UPDATE tour t
    JOIN dondat dd ON t.maTour = dd.maTour
    SET t.soChoTrong = t.soChoTrong + dd.soNguoi
    WHERE dd.trangThaiTT = 'Chờ thanh toán'
    AND TIMESTAMPDIFF(MINUTE, dd.thoiGianDat, NOW()) > 5;

    -- Chuyển trạng thái đơn sang Hết hạn
    UPDATE dondat
    SET trangThaiTT = 'Hết hạn'
    WHERE trangThaiTT = 'Chờ thanh toán'
    AND TIMESTAMPDIFF(MINUTE, thoiGianDat, NOW()) > 5;
END$$

CREATE DEFINER=`root`@`localhost` EVENT `xoa_tour_qua_han` ON SCHEDULE EVERY 1 HOUR STARTS '2026-06-04 19:55:17' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE tour
    SET trangThai = 'Đã kết thúc'
    WHERE trangThai IN ('Đang bán', 'Tạm dừng')
    AND ngayKhoiHanh < CURDATE()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
