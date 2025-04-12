<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- Tiêu đề card -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Sản phẩm</h4>
                        <form method="GET" class="d-flex w-30">
                            <input type="text" name="search" class="form-control border-dark" placeholder="Tìm tên sản phẩm"
                                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
                        </form>
                    </div>

                </div>
                <!-- Nội dung bảng sản phẩm -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../config/dbcon.php');

                            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                            $query = "SELECT * FROM products";

                            if (!empty($search)) {
                                $query .= " WHERE name LIKE '%$search%'";
                            }

                            $products = mysqli_query($conn, $query);

                            if (mysqli_num_rows($products) > 0) {
                                foreach ($products as $item) {
                            ?>
                                    <tr class="<?= $item['status'] == '1' ? 'opacity-50' : '' ?>">
                                        <td><?= $item['id']; ?> </td>
                                        <td><?= $item['name']; ?></td>
                                        <td>
                                            <img src="../images/<?= $item['image']; ?>" width="50px" height="50px" alt="<?= $item['name']; ?>">
                                        </td>
                                        <td>
                                            <span class="badge <?= $item['status'] == '0' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= $item['status'] == '0' ? "Còn hàng" : "Đã ẩn" ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit-product.php?id=<?= $item['id']; ?>" class="btn btn-primary">Sửa</a>
                                        </td>
                                        <td>
                                            <form action="code.php" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                <button type="submit" name="delete_product_btn" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'>Không tìm thấy sản phẩm phù hợp.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
</body>

<?php include("../admin/includes/footer.php"); ?>