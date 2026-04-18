<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'Quản trị viên') {
    header('Location: ../auth/dangNhap.php');
    exit();
}

// Xử lý tìm kiếm và lọc
$timKiem = $_GET['timKiem'] ?? '';
$vaiTro = $_GET['vaiTro'] ?? '';

$sql = "SELECT maND, hoTen, email, soDienThoai, vaiTro, diaChi, tenCongTy, diaChiCongTy, tyLeHoaHong FROM user WHERE 1=1";
$params = [];
$types = '';

if (!empty($timKiem)) {
    $sql .= " AND (hoTen LIKE ? OR email LIKE ?)";
    $params[] = "%$timKiem%";
    $params[] = "%$timKiem%";
    $types .= 'ss';
}

if (!empty($vaiTro)) {
    $sql .= " AND vaiTro = ?";
    $params[] = $vaiTro;
    $types .= 's';
}

$sql .= " ORDER BY maND ASC";

$stmt = $mysqli->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$users = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/QTV.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <?php include "../../includes/sideBar-admin.php"; ?>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-4">

                <div class="mb-4">
                    <h3 class="text-title">Quản lý người dùng</h3>
                </div>

                <hr>

                <div class="content-box mb-3">
                    <div class="row">
                        <form action="quanLyUsers.php" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="timKiem" class="form-control"
                                        placeholder="Tìm kiếm theo tên hoặc email..."
                                        value="<?= htmlspecialchars($timKiem) ?>">
                                </div>
                                <div class="col-md-3">
                                    <select name="vaiTro" class="form-select">
                                        <option value="">Tất cả vai trò</option>
                                        <option value="Khách hàng" <?= $vaiTro === 'Khách hàng' ? 'selected' : '' ?>>Khách
                                            hàng</option>
                                        <option value="Nhà phân phối tour" <?= $vaiTro === 'Nhà phân phối tour' ? 'selected' : '' ?>>Nhà phân phối</option>
                                        <option value="Quản trị viên" <?= $vaiTro === 'Quản trị viên' ? 'selected' : '' ?>>
                                            Quản trị viên</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary w-100">Tìm</button>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="themUsers.php" class="btn btn-success w-100">Thêm người dùng</a>
                                </div>
                            </div>
                        </form>

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
                            <?php while ($user = $users->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?= $user['maND'] ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($user['hoTen']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($user['email']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($user['soDienThoai']) ?>
                                    </td>
                                    <td>
                                        <?php if ($user['vaiTro'] === 'Quản trị viên'): ?>
                                            <span class="badge bg-danger">Admin</span>
                                        <?php elseif ($user['vaiTro'] === 'Nhà phân phối tour'): ?>
                                            <span class="badge bg-info text-dark">Nhà phân phối</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Khách hàng</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" type="button"
                                            onclick="xemUser(
                                                <?= $user['maND'] ?>,
                                                '<?= addslashes(htmlspecialchars($user['hoTen'])) ?>',
                                                '<?= addslashes(htmlspecialchars($user['email'])) ?>',
                                                '<?= addslashes(htmlspecialchars($user['soDienThoai'])) ?>',
                                                '<?= addslashes(htmlspecialchars($user['vaiTro'])) ?>',
                                                '<?= addslashes(htmlspecialchars($user['diaChi'] ?? '')) ?>',
                                                '<?= addslashes(htmlspecialchars($user['tenCongTy'] ?? '')) ?>',
                                                '<?= addslashes(htmlspecialchars($user['diaChiCongTy'] ?? '')) ?>',
                                                '<?= $user['tyLeHoaHong'] ?? '' ?>'
                                            )">Xem</button>
                                        <a href="themUsers.php?edit=<?= $user['maND'] ?>"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="../../actions/user/addUser.php?xoa=<?= $user['maND'] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Xác nhận xóa người dùng này?')">Xóa</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if ($users->num_rows === 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không tìm thấy người dùng nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>

                </div>
                <div class="content-box-chiTiet mt-3" id="userDetailBox" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Thông tin người dùng <span id="detailId" class="text-muted fs-6"></span></h5>
                        <button class="btn btn-sm btn-outline-secondary" onclick="dongBox()">✕ Đóng</button>
                    </div>
                    <hr class="mt-0">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Họ tên:</strong> <span id="detailHoTen"></span></p>
                            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                            <p><strong>Số điện thoại:</strong> <span id="detailSoDienThoai"></span></p>
                            <p><strong>Vai trò:</strong> <span id="detailVaiTro"></span></p>
                        </div>
                        <div class="col-md-6" id="detailExtra"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        function xemUser(id, hoTen, email, soDienThoai, vaiTro, diaChi, tenCongTy, diaChiCongTy, tyLeHoaHong) {
            document.getElementById('detailId').textContent = '#' + id;
            document.getElementById('detailHoTen').textContent = hoTen;
            document.getElementById('detailEmail').textContent = email;
            document.getElementById('detailSoDienThoai').textContent = soDienThoai;
            document.getElementById('detailVaiTro').textContent = vaiTro;

            let extra = '';
            if (vaiTro === 'Khách hàng') {
                extra = `<p><strong>Địa chỉ:</strong> ${diaChi || 'Chưa cập nhật'}</p>`;
            } else if (vaiTro === 'Nhà phân phối tour') {
                extra = `
            <p><strong>Tên công ty:</strong> ${tenCongTy || 'Chưa cập nhật'}</p>
            <p><strong>Địa chỉ công ty:</strong> ${diaChiCongTy || 'Chưa cập nhật'}</p>
            <p><strong>Tỷ lệ hoa hồng:</strong> ${tyLeHoaHong ? tyLeHoaHong + '%' : 'Chưa cập nhật'}</p>
        `;
            }
            document.getElementById('detailExtra').innerHTML = extra;

            const box = document.getElementById('userDetailBox');
            box.style.display = 'block';
            box.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        function dongBox() {
            document.getElementById('userDetailBox').style.display = 'none';
        }
    </script>
</body>

</html>