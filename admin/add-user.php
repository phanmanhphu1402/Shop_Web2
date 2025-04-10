<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white">
                        <h6 class="mb-0 text-white">Thêm người dùng</h6>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="name" placeholder="Nhập họ và tên" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" placeholder="Nhập email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" placeholder="Nhập số điện thoại" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="address" placeholder="Nhập địa chỉ" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="1" selected>Hoạt động</option>
                                    <option value="0">Bị khóa</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="user.php" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" name="save_user" class="btn btn-primary">Lưu người dùng</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include("../admin/includes/footer.php"); ?>
