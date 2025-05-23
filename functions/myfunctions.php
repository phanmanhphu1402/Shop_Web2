<?php
include("../config/dbcon.php");
function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table ORDER BY id DESC";
    return $query_run = mysqli_query($conn, $query);
}
function getByID($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE id='$id'";
    return $query_run = mysqli_query($conn, $query);
}

function totalValue($table)
{
    global $conn;
    $query = "SELECT COUNT(*) as `number` FROM $table";
    $totalValue = mysqli_query($conn, $query);
    $totalValue = mysqli_fetch_array($totalValue);
    return $totalValue['number'];
}
function getAllUsers()
{
    global $conn;
    $query = "SELECT `users`.*, COUNT(`order_detail`.`id`) AS `total_buy` FROM `users`
            LEFT JOIN `order_detail` ON `users`.`id` = `order_detail`.`user_id`
            GROUP BY `users`.`id`
            ORDER BY `users`.`creat_at` DESC";
    return $query_run = mysqli_query($conn, $query);
}

// order
function getAllOrder($type = -1, $from_date = null, $to_date = null, $location = null)
{
    global $conn;

    // Trạng thái đơn hàng
    $getStatus = "1,2,3,4";
    if ($type != -1) {
        $getStatus = intval($type);
    }

    // Câu truy vấn cơ bản
    $query = "SELECT `orders`.*, COUNT(`order_detail`.`id`) as `quantity`,
                    `users`.`name`, `users`.`email`, `users`.`phone`, `users`.`address` 
              FROM `orders`
              JOIN `users` ON `orders`.`user_id` = `users`.`id`
              LEFT JOIN `order_detail` ON `order_detail`.`order_id` = `orders`.`id`
              WHERE `orders`.`status` IN($getStatus)";

    // Thêm điều kiện lọc ngày bắt đầu
    if (!empty($from_date)) {
        $from_date = mysqli_real_escape_string($conn, $from_date);
        $query .= " AND DATE(`orders`.`created_at`) >= '$from_date'";
    }

    // Thêm điều kiện lọc ngày kết thúc
    if (!empty($to_date)) {
        $to_date = mysqli_real_escape_string($conn, $to_date);
        $query .= " AND DATE(`orders`.`created_at`) <= '$to_date'";
    }

    // Thêm điều kiện lọc địa điểm giao hàng
    if (!empty($location)) {
        $location = mysqli_real_escape_string($conn, $location);
        $query .= " AND `users`.`address` LIKE '%$location%'";
    }

    // Kết thúc truy vấn
    $query .= " GROUP BY `orders`.`id`
                ORDER BY `orders`.`id` DESC";
            
    
    return mysqli_query($conn, $query);
}


function getOrderDetail($order_id)
{
    global $conn;
    $query =    "SELECT `users`.`name`,`users`.`email`,`users`.`phone`,`users`.`address`,
                `products`.`name` as `name_product`, `products`.`selling_price`,`products`.`image`,
                `order_detail`.*  FROM `order_detail` 
                JOIN `users` ON `order_detail`.`user_id` = `users`.`id`
                JOIN `products` ON `products`.`id` = `order_detail`.`product_id`
                WHERE `order_id` = '$order_id'";
    return mysqli_query($conn, $query);
}

function totalPriceGet()
{
    global $conn;
    $query = "SELECT selling_price * quantity as price FROM `order_detail` WHERE `status` = 4";
    $prices = mysqli_query($conn, $query);
    $total_price = 0;
    foreach ($prices as $price) {
        $total_price += $price['price'];
    }
    return $total_price;
}

function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header("Location:" . $url);
    exit();
}
