<?php
session_start();
include("../middleware/adminMiddleware.php");
include("../config/dbcon.php");

if (isset($_POST['add_category_btn'])) {

    $name = $_POST['name'];
    $slug = $_POST['slug'] . "-" . rand(10, 99);
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? '1' : '0';
    $image = $_FILES['image']['name'];

    $path = "../images";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $cate_query = "INSERT INTO categories (name,slug,description,status,image) 
    VALUES ('$name', '$slug','$description',' $status', '$filename')";

    $cate_query_run = mysqli_query($conn, $cate_query);

    if ($cate_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("add-category.php", "Thêm danh mục thành công");
    } else {
        redirect("add-category.php", "Đã xảy ra lỗi");
    }
} else if (isset($_POST['update_category_btn'])) {

    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? '1' : '0';

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        //$update_filename= $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;

    } else {
        $update_filename = $old_image;
    }
    $path = "../images";
    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description', status='$status', image='$update_filename' WHERE id='$category_id'";
    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../images/" . $old_image)) {
                unlink("../images/" . $old_image);
            }
        }
        redirect("edit-category.php?id=$category_id", "Cập nhật danh mục thành công");
    } else {
        redirect("edit-category.php?id=$category_id", "Đã xảy ra lỗi");
    }
} else if (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
    $category_query_run = mysqli_query($conn, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];

    $delete_query = "DELETE FROM categories WHERE id='$category_id'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../images/" . $image)) {
            unlink("../images/" . $image);
        }
        redirect("category.php", "Xóa danh mục thành công");
    } else {
        redirect("caterory.php", "Đã xảy ra lỗi");

    }
} else if (isset($_POST['update_product_btn'])) {
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];

    // Escape dữ liệu để tránh lỗi và tấn công SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']) . "-" . rand(10, 99);
    $small_description = mysqli_real_escape_string($conn, $_POST['small_description']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $status = isset($_POST['status']) ? $_POST['status'] : '0';
    $qty = $_POST['qty'];

    $path = "../images";

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    // ✅ Đã thêm category_id
    $update_product_query = "UPDATE products SET 
        category_id='$category_id',
        name='$name',
        slug='$slug',
        small_description='$small_description',
        description='$description',
        original_price='$original_price',
        selling_price='$selling_price',
        status='$status',
        qty='$qty',
        image='$update_filename' 
        WHERE id='$product_id'";

    $update_product_query_run = mysqli_query($conn, $update_product_query);

    // ✅ Debug khi lỗi
    if (!$update_product_query_run) {
        echo "Lỗi truy vấn SQL: " . mysqli_error($conn);
        echo "<br>Query: " . $update_product_query;
        exit(); // Dừng xử lý tiếp để xem lỗi
    }

    if ($new_image != "") {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
        if (file_exists("../images/" . $old_image)) {
            unlink("../images/" . $old_image);
        }
    }
    redirect("edit-product.php?id=$product_id", "Cập nhật sản phẩm thành công");
} else if (isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    $product_query = "SELECT * FROM products WHERE id='$product_id'";
    $product_query_run = mysqli_query($conn, $product_query);
    $product_data = mysqli_fetch_array($product_query_run);
    $image = $product_data['image'];

    // Bắt lỗi ngoại lệ MySQL
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $delete_query = "DELETE FROM products WHERE id='$product_id'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            if (file_exists("../images/" . $image)) {
                unlink("../images/" . $image);
            }
            redirect("products.php", "Xóa sản phẩm thành công");
        }

    } catch (mysqli_sql_exception $e) {
        // Nếu lỗi là do khóa ngoại (foreign key)
        if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
            redirect("products.php", "Không thể xóa sản phẩm vì có đơn hàng chứa sản phẩm đó");
        } else {
            redirect("products.php", "Lỗi hệ thống: " . $e->getMessage());
        }
    }
} else if (isset($_POST['add_blog_btn'])) {
    $title = $_POST['title'];
    $slug = $_POST['slug'] . "-" . rand(10, 99);
    $small_content = $_POST['small_content'];
    $content = addslashes($_POST['content']);

    $image = $_FILES['image']['name'];

    $path = "../images";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if ($title != "" && $slug != "" && $content != "") {
        $blog_query = "INSERT INTO blog (title,slug,img,small_content,content) VALUES 
        ('$title', '$slug', '$filename', '$small_content', '$content')";

        $blog_query_run = mysqli_query($conn, $blog_query);

        if ($blog_query_run) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("add-blog.php", "Thêm bài viết thành công");
        } else {
            redirect("add-blog.php", "Đã xảy ra lỗi");
        }
    } else {
        redirect("add-product.php", "Bạn chưa điền đủ thông tin");
    }
} else if (isset($_POST['update_blog_btn'])) {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $slug = $_POST['slug'] . "-" . rand(10, 99);
    $small_content = $_POST['small_content'];
    $content = addslashes($_POST['content']);

    $path = "../images";

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        //$update_filename= $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;

    } else {
        $update_filename = $old_image;
    }

    $update_blog_query = "UPDATE
                            `blog`
                        SET
                            `title`         = '$title',
                            `slug`          = '$slug',
                            `img`           = '$update_filename',
                            `small_content` = '$small_content',
                            `content`       = '$content'
                        WHERE
                            `id` = '$id'";

    $update_blog_query_run = mysqli_query($conn, $update_blog_query);

    if ($update_blog_query_run) {
        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists("../images/" . $old_image)) {
                unlink("../images/" . $old_image);
            }
        }
        redirect("edit-blog.php?id=$id", "Cập nhật bài viết thành công");
    } else {
        redirect("edit-blog.php?id=$id", "Đã xảy ra lỗi");
    }
} else if (isset($_POST['delete_blog_btn'])) {
    $blog_id = $_POST['blog_id'];

    $blog_query = "SELECT * FROM blog WHERE id='$blog_id'";

    $blog_query_run = mysqli_query($conn, $blog_query);

    $blog_data = mysqli_fetch_array($blog_query_run);

    $image = $blog_data['img'];

    $delete_query = "DELETE FROM blog WHERE id='$blog_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../images/" . $image)) {
            unlink("../images/" . $image);
        }
        redirect("blog.php", "Xóa bài viết thành công");
    } else {
        redirect("blog.php", "Đã xảy ra lỗi");

    }
} else if (isset($_GET['order'])) {
    $order_id = $_GET['id'];
    $type = $_GET['order'];
    $query = "UPDATE `orders` SET `status` = '$type'
                WHERE `id` = '$order_id'";
    mysqli_query($conn, $query);

    $query = "UPDATE `order_detail` SET `status` = '$type'
                WHERE `order_id` = '$order_id'";
    mysqli_query($conn, $query);

    redirect("order-detail.php?id_order=$order_id", "Cập nhập trạng thái thành công");
} else if (isset($_POST['update_user_btn'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $update_query = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address'";

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query .= ", password='$hashed_password'";
    }

    $update_query .= " WHERE id='$user_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        redirect("user.php", "Cập nhật người dùng thành công");
    } else {
        redirect("user.php", "Đã xảy ra lỗi khi cập nhật");
    }
} else if (isset($_POST['save_user'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Kiểm tra email đã tồn tại chưa
    $check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        redirect("add-user.php", "Email đã tồn tại!");
        header("Location: add-user.php");
        exit();
    }

    // Mã hóa mật khẩu
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert dữ liệu
    $query = "INSERT INTO users (name, email, phone, address, password, status, creat_at) 
              VALUES ('$name', '$email', '$phone', '$address', '$hashPassword', '$status', NOW())";

    $result = mysqli_query($conn, $query);

    if ($result) {
        redirect("user.php", "Thêm người dùng thành công!");
        header("Location: user.php");
        exit();
    } else {
        redirect("user.php", "Có lỗi xảy ra khi thêm người dùng!");
        header("Location: add-user.php");
        exit();
    }
} {
    //header('Location: ./index.php');
}
?>