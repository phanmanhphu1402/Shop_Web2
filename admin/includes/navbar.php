<?php 
$page= substr($_SERVER['SCRIPT_NAME'], strripos($_SERVER['SCRIPT_NAME'],"/")+1);
 ?>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;"><p><b>Bảng điều khiển</b></p></a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
              <?php 
                if( $page== "index.php")
                {
                  echo " ";
                }
                else if($page== "category.php")
                {
                  echo "Tất cả danh muc";
                }
                else if($page== "add-category.php")
                {
                  echo "Thêm danh mục";
                }
                else if($page== "products.php")
                {
                  echo "Tất cả sản phẩm";
                }
                else if($page== "add-product.php")
                {
                  echo "Thêm sản phẩm";
                }
                else if($page== "user.php")
                {
                  echo "Quản lý người dùng";
                }
                else if($page== "order.php")
                {
                  echo "Quản lý đơn hàng";
                }
                else if($page== "order-detail.php")
                {
                  echo "Quản lý đơn hàng / order-detail ";
                }
                else if($page== "add-blog.php")
                {
                  echo "Thêm bài viết ";
                }
                else if($page== "blog.php")
                {
                  echo "Tất cả bài viết ";
                }
                else if($page== "edit-blog.php")
                {
                  echo "Chỉnh sửa bài viết ";
                }
                else if($page== "edit-user.php")
                {
                  echo "Chỉnh sửa người dùng ";
                }
                else if($page== "lock-user.php")
                {
                  echo "Khóa người dùng ";
                }
                else if($page== "edit-category.php")
                {
                  echo "Chỉnh sửa danh mục ";
                }
                else if($page== "edit-product.php")
                {
                  echo "Chỉnh sửa sản phẩm ";
                }
                else if($page== "profile.php")
                {
                  echo "Thông tin cá nhân ";
                }
                else if($page== "change-password.php")
                {
                  echo "Đổi mật khẩu ";
                }
                else if($page== "settings.php")
                {
                  echo "Cài đặt ";
                }
                else if($page== "logout.php")
                {
                  echo "Đăng xuất ";
                }
                else if($page== "unlock-user.php")
                {
                  echo "Mở khóa người dùng ";
                }
                else if($page== "view-order.php")
                {
                  echo "Xem đơn hàng ";
                }
                else if($page== "view-product.php")
                {
                  echo "Xem sản phẩm ";
                }
                else if($page== "view-blog.php")
                {
                  echo "Xem bài viết ";
                }
                else if($page== "view-category.php")
                {
                  echo "Xem danh mục ";
                }
                else
                {
                  echo " ";
                }
              ?>
            </li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
        </div>
      </div>
</nav>