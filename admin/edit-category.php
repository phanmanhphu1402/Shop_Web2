<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $category = getByID("categories", $id);

                    if (mysqli_num_rows($category) > 0) {
                        $data = mysqli_fetch_array($category);
                ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>Chỉnh sửa danh mục</h4>
                            </div>
                            <div class="card-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data"><!-- Uploads image -->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="category_id" value="<?= $data['id'] ?>">
                                            <label for=""><b>Tên danh mục</b></label>
                                            <input type="text" id="full-name" required value="<?= $data['name'] ?>" name="name" placeholder="Nhập tên danh mục" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <br>
                                            <label for=""><b>Đường dẫn (Slug)</b></label>
                                            <input type="text" id="slug-name" required value="<?= $data['slug'] ?>" name="slug" placeholder="Nhập slug" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <br>
                                            <label for=""><b>Mô tả</b></label>
                                            <input type="text" required value="<?= $data['description'] ?>" name="description" placeholder="Nhập mô tả" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <br>
                                            <label for=""><b>Hình ảnh</b></label>
                                            <input type="file" name="image" class="form-control">
                                            <label for="">Hình ảnh hiện tại</label>
                                            <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                            <img src="../images/<?= $data['image'] ?>" height="50px" width="50px" alt="">

                                        </div>
                                        <div class="col-md-6">
                                            <br>
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
                                        <div class="col-md-12">
                                            <br>
                                            <button type="submit" class="btn btn-primary" name="update_category_btn">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php
                    } else {
                        echo "Không tìm thấy danh mục";
                    }
                } else {
                    echo "Thiếu ID trên URL";
                }
                ?>
            </div>
        </div>
        </form>
    </div>
</body>
<script type="text/javascript" src="./assets/js/StringConvertToSlug.js"></script>
<?php include("../admin/includes/footer.php"); ?>
