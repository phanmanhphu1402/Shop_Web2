<?php
include("./includes/header.php");
include("./config/dbcon.php"); // Đảm bảo có kết nối CSDL nếu chưa có

// Lấy tham số
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$limit = 8;
$offset = ($page - 1) * $limit;

// Xây dựng câu truy vấn lọc sản phẩm
$sql = "SELECT * FROM products WHERE status = 0";
$countSql = "SELECT COUNT(*) as total FROM products WHERE status = 0";
$category_query = mysqli_query($conn, "SELECT name FROM categories WHERE slug = '$type' LIMIT 1");
if ($category_query && mysqli_num_rows($category_query) > 0) {
    $category_name = mysqli_fetch_assoc($category_query)['name'];
}
$category_name = null;
if ($type) {
    $type = mysqli_real_escape_string($conn, $type);
    $sql .= " AND category_id IN (SELECT id FROM categories WHERE slug = '$type')";
    $countSql .= " AND category_id IN (SELECT id FROM categories WHERE slug = '$type')";
}

$sql .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

// Lấy dữ liệu sản phẩm
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Lấy tổng số sản phẩm
$countResult = mysqli_query($conn, $countSql);
$total = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($total / $limit);

?>



<body>
    <!-- products content -->
    <div class="bg-main">
        <div class="container">
            <div class="box">
                <div class="breadcumb">
                    <a href="index.php">Trang chủ</a>
                    <span><i class='bx bxs-chevrons-right'></i></span>
                    <a href="./products.php">Tất cả sản phẩm</a>
                    <?php if ($category_name): ?>
                        <span><i class='bx bxs-chevrons-right'></i></span>
                        <span><?= $category_name ?></span>
                    <?php endif; ?>
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
                                Danh mục
                            </span>
                            <ul class="filter-list">
                                <?php
                                $categories = getAllActive("categories");
                                if (mysqli_num_rows($categories) > 0) {
                                    foreach ($categories as $item) {
                                ?>
                                        <li><a href="./products.php?type=<?= $item['slug']?>"><?= $item['name']; ?></a></li>
                                <?php
                                    }
                                } else {
                                    echo "Không có danh mục nào";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-9 col-md-12">
                        <div class="box filter-toggle-box">
                            <button id="filter-toggle">Lọc</button>
                        </div>
                        <div class="box">
                            <div class="row" id="products">
                            <?php foreach ($products as $product) { ?>
                                <div class="col-3 col-md-4 col-sm-6">
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
                                                <button class="btn-flat btn-hover btn-cart-add">
                                                    <i class='bx bxs-cart-add'></i>
                                                </button>    
                                            </div>
                                            <div class="product-card-name">
                                                <?= $product['name'] ?>
                                            </div>
                                            <div class="product-price">
                                                <?php 
                                                    $formatted_price = number_format($product['selling_price'], 0, ',', '.') . '₫';
                                                    $formatted_original = number_format($product['original_price'], 0, ',', '.') . '₫';
                                                ?>
                                                <span style="color: red; font-weight: bold;">
                                                    <?= $formatted_price ?>
                                                </span>
                                                <del style="color: gray; opacity: 0.6; margin-left: 8px;">
                                                    <?= $formatted_original ?>
                                                </del>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>

                        <!-- Phân trang -->
                        <?php if ($totalPages > 1): ?>
                            <div class="box">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <?php
                                            $queryParams = "?page=$i";
                                            if ($type) $queryParams .= "&type=$type";
                                        ?>
                                        <li>
                                            <a href="products.php<?= $queryParams ?>" <?= ($i == $page) ? "class='active'" : "" ?>>
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

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
</body>
</html>
