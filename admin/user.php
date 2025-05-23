<?php
include("../admin/includes/header.php");

// $users= getAll("users");
$users = getAllUsers();

?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Người dùng</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="d-flex justify-content-begin px-3 pb-3">
                            <a href="add-user.php" class="btn btn-success">
                            <i class="fas fa-user-plus me-1"></i> + Thêm người dùng
                            </a>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Tên</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10 ps-2">Số điện thoại</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10 ps-2">Địa chỉ</th>
                                        <th style="width: 80px;" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Tổng đơn</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Ngày bắt đầu</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Trạng thái</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= $user['name'] ?></h6>
                                                        <p class="text-xs text-secondary mb-0"><?= $user['email'] ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"> <?= $user['phone'] ?> </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"> <?= $user['address'] ?> </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?= $user['total_buy'] ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    <?= date('d-m-Y', strtotime($user['creat_at'])); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php if ($user['status'] == 1): ?>
                                                    <span class="badge bg-success">Hoạt động</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Bị khóa</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="edit-user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                                                <?php if ($user['status'] == 1): ?>
                                                    <a href="lock-user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger">Khóa</a>
                                                <?php else: ?>
                                                    <a href="unlock-user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-success">Mở</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
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