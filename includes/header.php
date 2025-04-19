<?php
session_start();
include("./functions/userfunctions.php");

// Xử lý các tham số GET
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$type   = isset($_GET["type"]) ? $_GET["type"] : "";
$page   = isset($_GET["page"]) ? (int)$_GET["page"] - 1 : 0;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuixin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/app.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/reponsive.css">
    
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- JS Libraries -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</head>

<body>
    <!-- Mobile Menu -->
    <div class="mobile-menu bg-second">
        <a href="./index.php" class="mb-logo">TúiXịn</a>
        <span class="mb-menu-toggle" id="mb-menu-toggle">
            <i class='bx bx-menu'></i>
        </span>
    </div>

    <!-- Header Wrapper -->
    <div class="header-wrapper" id="header-wrapper">
        <!-- Close Menu Button -->
        <span class="mb-menu-toggle mb-menu-close" id="mb-menu-close">
            <i class='bx bx-x'></i>
        </span>

        <!-- Top Header -->
        <div class="bg-second">
            <div class="top-header container">
                <ul class="devided">
                    <li><a>+84 938 338 637</a></li>
                    <li><a>tuixin@mail.com</a></li>
                </ul>
            </div>
        </div>

        <!-- Mid Header -->
        <div class="bg-main">
            <div class="mid-header container">
                <a href="index.php" class="logo">TÚIXỊN</a>

                <!-- Form tìm kiếm -->
                <form class="search" method="get" action="<?= isset($type_post) ? './blog.php' : './products.php' ?>">
                    <input name="search" type="text" value="<?= htmlspecialchars($search) ?>" placeholder="Tìm kiếm">
                    <button type="submit" style="border:none">
                        <i class='bx bx-search-alt'></i>
                    </button>
                </form>

                <!-- Menu người dùng -->
                <ul class="user-menu">
                    <li><a href="#"><i class='bx bx-bell'></i></a></li>

                    <?php if (isset($_SESSION['auth'])): ?>
                        <li class="mega-dropdown">
                            <a href="#"><i class='bx bx-user-circle'></i></a>
                            <div class="mega-content" style="width:auto; display:inline-block; right:0;">
                                <div class="row">
                                    <div class="box">
                                        <h3>Xin chào <?= $_SESSION['auth_user']['name'] ?>!</h3>
                                        <ul>
                                            <li><a href="user-profile.php">Trang cá nhân</a></li>
                                            <li><a href="./cart-status.php">Đơn hàng</a></li>
                                            <li><a href="logout.php">Đăng xuất</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="mega-dropdown">
                            <a href="#"><i class='bx bx-user-circle'></i></a>
                            <div class="mega-content">
                                <div class="row">
                                    <div class="box">
                                        <ul>
                                            <li><a href="login.php">Đăng nhập</a></li>
                                            <li><a href="register.php">Đăng ký</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>

                    <li><a href="./cart.php"><i class='bx bx-cart'></i></a></li>
                </ul>
            </div>
        </div>

        <!-- Main Menu -->
        <div class="bg-second">
            <div class="bottom-header container">
                <ul class="main-menu">
                    <li><a href="index.php">Trang chủ</a></li>

                    <!-- Danh mục sản phẩm -->
                    <li class="mega-dropdown">
                        <a href="#">Danh mục <i class='bx bxs-chevron-down'></i></a>
                        <div class="mega-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <ul>
                                            <?php
                                            $categories = getAllActive("categories");
                                            if (mysqli_num_rows($categories) > 0) {
                                                foreach ($categories as $item) {
                                                    echo "<li><a href='./products.php?type={$item['slug']}'>{$item['name']}</a></li>";
                                                }
                                            } else {
                                                echo "<li>Không có danh mục</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li><a href="./blog.php">Blog</a></li>
                    <li><a href="./timkiem.php">Tìm kiếm nâng cao</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Header Wrapper -->
</body>
</html>
