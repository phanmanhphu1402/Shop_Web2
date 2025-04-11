<?php
session_start();
include("../config/dbcon.php");
include("../functions/myfunctions.php");

if (isset($_POST['order'])){
    $user_id    = $_SESSION['auth_user']['id'];
    $product_id = $_POST['product_id'];
    $quantity   = $_POST['quantity'];

    $product = getByID("products",$product_id);
    if(mysqli_num_rows($product) >0){
        $product = mysqli_fetch_array($product);
        $slug    = $product['slug'];
        if ($quantity != "" && $quantity <= $product['qty']){
            $selling_price  = $product['selling_price'];
            $insert_query   = "INSERT INTO order_detail (`user_id`, `product_id`, `selling_price`, `quantity`) VALUES ('$user_id','$product_id','$selling_price','$quantity')";
            $insert_query_run=mysqli_query($conn,$insert_query);
            if($insert_query_run){
                $_SESSION['message']="Thêm vào giỏ hàng thành công";
                header("Location: ../cart.php");
            }
        }else{
            $_SESSION['message']="Số lượng sản phẩm không phù hợp";
            header("Location: ../product-detail.php?slug=$slug");
        }
    }else{
        $_SESSION['message']="Đã xảy ra lỗi không đáng có";
        header("Location: ../products.php");
    }    
}else if (isset($_GET['deleteID'])){
    $user_id    = $_SESSION['auth_user']['id'];
    $order_id   = $_GET['deleteID'];
    $query =    "DELETE FROM `order_detail` 
                WHERE `id` = '$order_id' AND `user_id` = '$user_id'";
    mysqli_query($conn, $query);
    $_SESSION['message']="Xóa sản phẩm thành công";
    header("Location: ../cart.php");
}else if (isset($_POST['update_product'])){
    $user_id    = $_SESSION['auth_user']['id'];
    $product_id = $_POST['product_id'];
    $quantity   = $_POST['quantity'];

    // Lấy Số lương
    $query          = "SELECT `qty` FROM `products` WHERE `id` = '$product_id'";
    $total_quantity = mysqli_fetch_array(mysqli_query($conn, $query))['qty'];

    // Kiểm tra số lượng còn lại trong kho
    if ($total_quantity > $quantity){
        $query =    "UPDATE `order_detail` SET `quantity` = $quantity 
                WHERE `product_id` = '$product_id' AND `user_id` = '$user_id' AND `status` = '1'";
        mysqli_query($conn, $query);
        $_SESSION['message']="Cập nhập sản phẩm thành công";
    }else{
        $_SESSION['message']="Cập nhập số lượng sản phẩm quá lớn";
    }
    
    header("Location: ../cart.php");

}else if (isset($_POST['buy_product'])) {
    $user_id        = $_SESSION['auth_user']['id'];

    $name           = mysqli_real_escape_string($conn, $_POST['name']);
    $phone          = mysqli_real_escape_string($conn, $_POST['phone']);
    $address        = mysqli_real_escape_string($conn, $_POST['address']);
    $addtional      = mysqli_real_escape_string($conn, $_POST['addtional'] ?? '');
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? 'bacs');

    if (!$name || !$phone || !$address) {
        $_SESSION['message'] = "Vui lòng điền đầy đủ thông tin thanh toán.";
        exit();
    }

    // Lấy đơn hàng chưa thanh toán
    $query = "SELECT od.quantity, p.qty, p.id, p.name
              FROM order_detail od
              JOIN products p ON od.product_id = p.id
              WHERE od.status = 1 AND od.user_id = '$user_id'";
    $check_products = mysqli_query($conn, $query);

    $check = true;
    foreach ($check_products as $product) {
        if ($product['quantity'] > $product['qty']) {
            $_SESSION['message'] = "Sản phẩm {$product['name']} chỉ còn {$product['qty']} cái trong kho.";
            $check = false;
            header("Location: ../cart.php");
            exit();
        }
    }

    // Nếu mọi thứ ổn => tiến hành đặt hàng
    if ($check) {
        $insert_order = "INSERT INTO orders (user_id, addtional, payment)
                         VALUES ('$user_id', '$addtional', '$payment_method')";
        $run_order = mysqli_query($conn, $insert_order);
        $order_id = mysqli_insert_id($conn);

        if ($run_order) {
            // Cập nhật trạng thái trong order_detail
            $update_detail = "UPDATE order_detail
                              SET status = 2, order_id = '$order_id'
                              WHERE user_id = '$user_id' AND status = 1";
            mysqli_query($conn, $update_detail);

            // Cập nhật lại số lượng tồn trong kho
            foreach ($check_products as $product) {
                $new_qty = $product['qty'] - $product['quantity'];
                $product_id = $product['id'];
                mysqli_query($conn, "UPDATE products SET qty = '$new_qty' WHERE id = '$product_id'");
            }

            // Cập nhật thông tin người dùng
            $update_user = "UPDATE users SET name = '$name', phone = '$phone', address = '$address'
                            WHERE id = '$user_id'";
            mysqli_query($conn, $update_user);

            $_SESSION['message'] = "Đặt hàng thành công!!";
            echo 1;
        } else {
            $_SESSION['message'] = "Không thể tạo đơn hàng.";
        }
    }

}else if(isset($_POST['rate'])){
    $user_id    = $_SESSION['auth_user']['id'];
    $id         = $_POST['id'];
    $rate       = $_POST['rating'];
    $comment    = $_POST['comment'];

    $query =    "UPDATE `order_detail` SET `rate` = '$rate', `comment` = '$comment'
                WHERE `id` = '$id' AND `user_id` = '$user_id' AND `status` = '4'";
    mysqli_query($conn, $query);

    $_SESSION['message']="Đánh giá sản phẩm thành công";
    header("Location: ../cart-status.php");
}

?>