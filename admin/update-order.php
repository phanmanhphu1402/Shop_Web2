<?php
include("../config/dbcon.php"); // hoặc nơi kết nối CSDL của bạn
include("../admin/includes/header.php");

$id = $_GET['id'];
$query = "SELECT * FROM orders WHERE id = $id";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);
?>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0 text-white">Cập nhật trạng thái đơn hàng #<?= $order['id'] ?></h6>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="2" <?= $order['status'] == 2 ? 'selected' : '' ?>>Đã đặt</option>
                                    <option value="3" <?= $order['status'] == 3 ? 'selected' : '' ?>>Đang giao</option>
                                    <option value="4" <?= $order['status'] == 4 ? 'selected' : '' ?>>Hoàn tất</option>
                                </select>
                            </div>
                            <button type="submit" name="update_order" class="btn btn-success">Lưu thay đổi</button>
                            <a href="order.php" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<?php include("../admin/includes/footer.php"); ?>
