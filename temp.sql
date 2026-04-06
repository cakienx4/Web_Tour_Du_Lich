-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3300
-- Generation Time: Apr 06, 2026 at 10:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tavivu`
--

-- --------------------------------------------------------

--
-- Table structure for table `baocao`
--

CREATE TABLE `baocao` (
  `maBaoCao` int(10) UNSIGNED NOT NULL,
  `maTour` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `noiDung` text NOT NULL,
  `ngayGui` date NOT NULL,
  `trangThaiXuLy` enum('choPhanHoi','daXuLy') NOT NULL DEFAULT 'choPhanHoi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diemden`
--

CREATE TABLE `diemden` (
  `maDiemDen` int(10) UNSIGNED NOT NULL,
  `tenDiemDen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `moTa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vungMien` enum('Bắc','Trung','Nam') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dondat`
--

CREATE TABLE `dondat` (
  `maDon` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `maTour` int(10) UNSIGNED NOT NULL,
  `ngayDat` date NOT NULL,
  `soNguoi` int(11) NOT NULL,
  `tongTien` decimal(18,2) NOT NULL,
  `phuongThucTT` enum('online','tienMat') NOT NULL,
  `ngayThanhToan` date DEFAULT NULL,
  `trangThaiTT` enum('choPhanHoi','daThanhToan','daHuy') NOT NULL DEFAULT 'choPhanHoi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phanhoi`
--

CREATE TABLE `phanhoi` (
  `maPhanHoi` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `maBaoCao` int(10) UNSIGNED NOT NULL,
  `noiDung` text NOT NULL,
  `ngayGui` date NOT NULL,
  `trangThai` enum('chuaXem','daXem') NOT NULL DEFAULT 'chuaXem'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `maTour` int(10) UNSIGNED NOT NULL,
  `maND` int(10) UNSIGNED NOT NULL,
  `tenTour` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `moTa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giaTour` decimal(18,2) UNSIGNED NOT NULL,
  `ngayKhoiHanh` date NOT NULL,
  `soChoTrong` int(10) UNSIGNED NOT NULL,
  `trangThai` enum('Chờ phê duyệt','Đang hoạt động','Đã kết thúc') NOT NULL DEFAULT 'Chờ phê duyệt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_diemden`
--

CREATE TABLE `tour_diemden` (
  `maDiemDen` int(10) UNSIGNED NOT NULL COMMENT 'Vừa là PK, vừa là FK',
  `maTour` int(10) UNSIGNED NOT NULL COMMENT 'Vừa là PK, vừa là FK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `maND` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matKhau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `soDienThoai` varchar(10) NOT NULL,
  `vaiTro` enum('Quản trị viên','Khách hàng','Nhà phân phối tour') NOT NULL DEFAULT 'Khách hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baocao`
--
ALTER TABLE `baocao`
  ADD PRIMARY KEY (`maBaoCao`),
  ADD KEY `maND` (`maND`),
  ADD KEY `maTour` (`maTour`);

--
-- Indexes for table `diemden`
--
ALTER TABLE `diemden`
  ADD PRIMARY KEY (`maDiemDen`);

--
-- Indexes for table `dondat`
--
ALTER TABLE `dondat`
  ADD PRIMARY KEY (`maDon`),
  ADD KEY `maND` (`maND`),
  ADD KEY `maTour` (`maTour`);

--
-- Indexes for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD PRIMARY KEY (`maPhanHoi`),
  ADD KEY `maND` (`maND`),
  ADD KEY `maBaoCao` (`maBaoCao`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`maTour`),
  ADD KEY `maND` (`maND`);

--
-- Indexes for table `tour_diemden`
--
ALTER TABLE `tour_diemden`
  ADD PRIMARY KEY (`maDiemDen`,`maTour`),
  ADD KEY `maTour` (`maTour`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`maND`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baocao`
--
ALTER TABLE `baocao`
  MODIFY `maBaoCao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diemden`
--
ALTER TABLE `diemden`
  MODIFY `maDiemDen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dondat`
--
ALTER TABLE `dondat`
  MODIFY `maDon` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phanhoi`
--
ALTER TABLE `phanhoi`
  MODIFY `maPhanHoi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `maTour` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `maND` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baocao`
--
ALTER TABLE `baocao`
  ADD CONSTRAINT `baocao_ibfk_1` FOREIGN KEY (`maND`) REFERENCES `user` (`maND`),
  ADD CONSTRAINT `baocao_ibfk_2` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`);

--
-- Constraints for table `dondat`
--
ALTER TABLE `dondat`
  ADD CONSTRAINT `dondat_ibfk_1` FOREIGN KEY (`maND`) REFERENCES `user` (`maND`),
  ADD CONSTRAINT `dondat_ibfk_2` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`);

--
-- Constraints for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD CONSTRAINT `phanhoi_ibfk_1` FOREIGN KEY (`maND`) REFERENCES `user` (`maND`),
  ADD CONSTRAINT `phanhoi_ibfk_2` FOREIGN KEY (`maBaoCao`) REFERENCES `baocao` (`maBaoCao`);

--
-- Constraints for table `tour_diemden`
--
ALTER TABLE `tour_diemden`
  ADD CONSTRAINT `tour_diemden_ibfk_1` FOREIGN KEY (`maDiemDen`) REFERENCES `diemden` (`maDiemDen`),
  ADD CONSTRAINT `tour_diemden_ibfk_2` FOREIGN KEY (`maTour`) REFERENCES `tour` (`maTour`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
