<?php
include("../admin/includes/header.php");

$type = $_GET['type'] ?? -1;
$from_date = $_GET['from_date'] ?? null;
$to_date = $_GET['to_date'] ?? null;
$location = $_GET['location'] ?? null;

if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

$orders = getAllOrder($type, $from_date, $to_date, $location);

?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Quản lý đơn hàng </h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <a href='./order.php' style="margin-left: 20px"><span class="badge badge-sm bg-gradient-secondary">Tất cả</span></a>
                            <a href='./order.php?type=2' style="margin-left: 20px"><span class="badge badge-sm bg-gradient-primary">Đã đặt</span></a>
                            <a href='./order.php?type=3' style="margin-left: 20px"><span class='badge badge-sm bg-gradient-info'>Đang giao</span></a>
                            <a href='./order.php?type=4' style="margin-left: 20px"><span class="badge badge-sm bg-gradient-success">Hoàn tất</span></a>
                            <form method="get" action="./order.php" class="row g-3 px-4 py-2">
                                <div class="col-md-3">
                                    <label for="from_date" class="form-label">Từ ngày</label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" value="<?= $_GET['from_date'] ?? '' ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="to_date" class="form-label">Đến ngày</label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" value="<?= $_GET['to_date'] ?? '' ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="location" class="form-label">Địa điểm giao</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="VD: Quận 1, TP.HCM" value="<?= $_GET['location'] ?? '' ?>">
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                                </div>
                            </form>

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Khách hàng</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sản phẩm</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Địa chỉ </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Đánh giá</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thời gian đặt </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($orders as $order) {
                                    ?>
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">&nbsp &nbsp #<?= $order['id'] ?></p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= $order['name'] ?></h6>
                                                        <p class="text-xs text-secondary mb-0"><?= $order['email'] ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <!-- <p class="text-xs font-weight-bold mb-0">
                                                    <a href="./order-detail.php?id_order=<?= $order['id'] ?>" class="btn btn-sm btn-warning">Chi tiết đơn hàng</a>
                                                </p> -->
                                                <p class="text-xs text-secondary mb-0">Số lượng: <?= $order['quantity'] ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?= $order['address'] ?></p>
                                                <p class="text-xs text-secondary mb-0"><?= $order['phone'] ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php
                                                if ($order['status'] == 2) {
                                                    echo '<span class="badge badge-sm bg-gradient-primary">Đã đặt</span>';
                                                } else if ($order['status'] == 3) {
                                                    echo '<span class="badge badge-sm bg-gradient-info">Đang giao</span>';
                                                } else if ($order['status'] == 4) {
                                                    echo '<span class="badge badge-sm bg-gradient-success">Hoàn tất</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php 
                                                    if (isset($order['rate']) && $order['rate'] > 0) {
                                                        echo str_repeat("⭐", $order['rate']); // ví dụ 4 => ⭐⭐⭐⭐
                                                    } else {
                                                        echo 'Chưa đánh giá';
                                                    }
                                                ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?= date('d-m-Y', strtotime($order['created_at'])); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="./order-detail.php?id_order=<?= $order['id'] ?>" class="btn btn-sm btn-warning">Chi tiết đơn hàng</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include("../admin/includes/footer.php"); ?>