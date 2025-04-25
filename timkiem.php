<?php

include("./includes/header.php");


$page       = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search     = isset($_GET['search']) ? $_GET['search'] : '';
$type       = isset($_GET['type']) ? $_GET['type'] : '';
$min_price = (isset($_GET['min_price']) && $_GET['min_price'] !== '') ? (int)$_GET['min_price'] : null;
$max_price = (isset($_GET['max_price']) && $_GET['max_price'] !== '') ? (int)$_GET['max_price'] : null;
$limit = 6;
$offset = ($page - 1) * $limit;

// Lấy sản phẩm
$products = getLatestProducts($limit, $offset, $type, $search, $min_price, $max_price);

?>

<body>
    <!-- products content -->
    <div class="bg-main">
        <div class="container">
            <div class="box">
                <div class="breadcumb">
                    <a href="index.php">Trang chủ</a>
                    <span><i class='bx bxs-chevrons-right'></i></span>
                    <a href="./timkiem.php">Tìm kiếm nâng cao</a>
                </div>
            </div>
            <div class="box">
                <div class="row">
                    <div class="col-3 filter-col" id="filter-col">
                        <div class="box filter-toggle-box">
                            <button class="btn-flat btn-hover" id="filter-close">close</button>
                        </div>
                        <div class="box">
                            <span class="filter-header">
                                Tìm kiếm nâng cao
                            </span>
                            <form method="GET" action="timkiem.php" id="search-form" onsubmit="return validatePriceRange();">

                                <div class="box">

                                    <div class="form-group">
                                        <label class="filter-header" for="search_name">Tên sản phẩm</label>
                                        <input type="text" name="search" id="search_name" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="filter-header" for="price_range">Khoảng giá</label>
                                        <div style="display: flex; gap: 10px;">
                                            <input type="number" name="min_price" placeholder="Giá từ" value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : '' ?>" class="form-control" />
                                            <input type="number" name="max_price" placeholder="Giá đến" value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : '' ?>" class="form-control" />
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="filter-header" for="category">Loại sản phẩm</label>
                                        <select name="type" id="category">
                                            <option value="">Tất cả</option>
                                            <?php
                                            $categories = getAllActive("categories");
                                            if (mysqli_num_rows($categories) > 0) {
                                                foreach ($categories as $item) {
                                                    $selected = (isset($_GET['type']) && $_GET['type'] == $item['slug']) ? 'selected' : '';
                                                    echo "<option value='{$item['slug']}' $selected>{$item['name']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Tìm</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- <div class="box">
                            <ul class="filter-list">
                                <li>
                                    <button type="submit" class="btn btn-primary">OK</button>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                    <div class="col-9 col-md-12">
                        <div class="box filter-toggle-box">
                            <button id="filter-toggle">Lọc</button>
                        </div>
                        <div class="box">
                            <div class="row" id="products">
                                <?php foreach ($products as $product) { ?>
                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                <a href="./product-detail.php?slug=<?= $product['slug'] ?>">
                                                    <img src="./images/<?= $product['image'] ?>" alt="">
                                                    <img src="./images/<?= $product['image'] ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="product-card-info">
                                                <div class="product-btn">
                                                    <a href="./product-detail.php?slug=<?= $product['slug'] ?>" class="btn-flat btn-hover btn-shop-now">Mua ngay</a>
                                                    <!-- <button class="btn-flat btn-hover btn-cart-add">
                                                        <i class='bx bxs-cart-add'></i>
                                                    </button> -->

                                                </div>
                                                <div class="product-card-name">
                                                    <?= $product['name'] ?>
                                                </div>
                                                <div class="product-card-price">
                                                    <?php
                                                    $formatted_price = number_format($product['selling_price'], 0, ',', '.') . '₫';
                                                    $formatted_original = number_format($product['original_price'], 0, ',', '.') . '₫';
                                                    ?>
                                                    <span><del><?= $formatted_original ?></del></span>
                                                    <span class="curr-price"><?= $formatted_price ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="box">
                            <ul class="pagination">
                                <?php
                                // Tổng sản phẩm sau lọc
                                $totalFiltered = getFilteredProductCount($type, $search, $min_price, $max_price);
                                $totalPages = ceil($totalFiltered / $limit);
                                $queryStr = http_build_query([
                                    'search'     => $search,
                                    'type'       => $type,
                                    'min_price'  => $min_price,
                                    'max_price'  => $max_price
                                ]);
                                // Trang số
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    $active = ($i == $page) ? "class='active'" : "";
                                    echo "<li><a href='?page=$i&$queryStr' $active>$i</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end products content -->

    <!-- footer -->
    <?php include("./includes/footer.php") ?>
    <!-- app js -->
    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/products.js"></script>
    <script>
        function validatePriceRange() {
            const minPrice = parseInt(document.querySelector('[name="min_price"]').value) || 0;
            const maxPrice = parseInt(document.querySelector('[name="max_price"]').value) || 0;

            if (minPrice > 0 && maxPrice > 0 && maxPrice < minPrice) {
                alert("⚠️ Giá đến phải lớn hơn hoặc bằng giá từ. Vui lòng nhập lại!");
                return false; // Ngăn không cho submit
            }

            return true; // Cho phép submit
        }
    </script>
</body>

</html>