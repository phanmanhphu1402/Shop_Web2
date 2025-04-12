<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['id'])) // Kiểm tra xem có tham số id trên URL không
                {
                    $id = $_GET['id'];
                    $product = getByID("products", $id);

                    if (mysqli_num_rows($product) > 0) // Kiểm tra sản phẩm có tồn tại không
                    {
                        $data = mysqli_fetch_array($product);
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Sửa sản phẩm
                                    <a href="products.php" class="btn btn-primary float-end">Quay lại</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <!-- Form xử lý cập nhật sản phẩm -->
                                    <div class="row">
                                        <!-- Chọn danh mục -->
                                        <div class="col-md-12">
                                            <label class="mb-0"><b>Chọn danh mục</b></label>
                                            <select name="category_id" class="form-select mb-2">
                                                <option selected>Chọn danh mục</option>
                                                <?php
                                                $categories = getAll("categories");
                                                if (mysqli_num_rows($categories) > 0) {
                                                    foreach ($categories as $item) {
                                                        ?>
                                                        <option value="<?= $item['id']; ?>" <?= $data['category_id'] == $item['id'] ? 'selected' : '' ?>>
                                                            <?= $item['name'] ?>
                                                        </option>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "Không có danh mục nào";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Tên sản phẩm -->
                                        <div class="col-md-6">
                                            <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                                            <br>
                                            <label class="mb-0"><b>Tên</b></label>
                                            <input type="text" required name="name" value="<?= $data['name']; ?>"
                                                placeholder="Nhập tên sản phẩm" class="form-control mb-2">
                                        </div>

                                        <!-- Slug -->
                                        <div class="col-md-6">
                                            <br>
                                            <label class="mb-0"><b>Slug</b></label>
                                            <input type="text" required name="slug" value="<?= $data['slug']; ?>"
                                                placeholder="Nhập slug" class="form-control mb-2">
                                        </div>

                                        <!-- Mô tả ngắn -->
                                        <div class="col-md-12">
                                            <br>
                                            <label class="mb-0"><b>Mô tả ngắn</b></label>
                                            <textarea required name="small_description" placeholder="Nhập mô tả ngắn"
                                                class="form-control mb-2"><?= $data['small_description']; ?></textarea>
                                        </div>

                                        <!-- Mô tả chi tiết -->
                                        <div class="col-md-12">
                                            <br>
                                            <label class="mb-0"><b>Mô tả chi tiết</b></label>
                                            <textarea required name="description" placeholder="Nhập mô tả chi tiết"
                                                class="form-control mb-2"><?= $data['description']; ?></textarea>
                                        </div>

                                        <!-- Giá gốc -->
                                        <div class="col-md-6">
                                            <br>
                                            <label class="mb-0"><b>Giá gốc</b></label>
                                            <input type="text" required name="original_price"
                                                value="<?= $data['original_price']; ?>" placeholder="Nhập giá gốc"
                                                class="form-control mb-2">
                                        </div>

                                        <!-- Giá bán -->
                                        <div class="col-md-6">
                                            <br>
                                            <label class="mb-0"><b>Giá bán</b></label>
                                            <input type="text" required name="selling_price"
                                                value="<?= $data['selling_price']; ?>" placeholder="Nhập giá bán"
                                                class="form-control mb-2">
                                        </div>

                                        <!-- Hình ảnh -->
                                        <div class="col-md-12">
                                            <br>
                                            <label class="mb-0"><b>Hình ảnh</b></label>
                                            <input type="file" name="image" class="form-control mb-2">
                                            <label for="">Hình hiện tại</label>
                                            <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                            <img src="../images/<?= $data['image'] ?>" height="50px" width="50px"
                                                alt="Hình sản phẩm">
                                        </div>

                                        <!-- Số lượng -->
                                        <div class="col-md-6">
                                            <br>
                                            <label class="mb-0"><b>Số lượng</b></label>
                                            <input type="number" required name="qty" value="<?= $data['qty']; ?>"
                                                placeholder="Nhập số lượng" class="form-control mb-2">
                                        </div>

                                        <!-- Trạng thái -->
                                        <div class="col-md-6">
                                            <label class="mb-0"><b>Trạng thái</b></label><br>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status_active"
                                                    value="0" <?= $data['status'] == '0' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="status_active">Hiển thị</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status_inactive"
                                                    value="1" <?= $data['status'] == '1' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="status_inactive">Ẩn</label>
                                            </div>
                                        </div>

                                        <!-- Nút cập nhật -->
                                        <div class="col-md-12">
                                            <br>
                                            <button type="submit" class="btn btn-primary" name="update_product_btn">Cập
                                                nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "Không tìm thấy sản phẩm với ID đã cho";
                    }
                } else {
                    echo "Thiếu ID trong đường dẫn URL";
                }
                ?>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<?php include("../admin/includes/footer.php"); ?>