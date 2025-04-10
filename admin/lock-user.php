<?php
session_start();
include("../config/dbcon.php"); // hoặc nơi kết nối CSDL của bạn
include("../functions/myfunctions.php");

if(isset($_GET['id']))
{
    $user_id = $_GET['id'];

    $query = "UPDATE users SET status = 0 WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if($result)
    {
        redirect("user.php", "Khóa người dùng thành công");
    }
    else
    {
        redirect("user.php", "Đã xảy ra lỗi khi khóa người dùng");
    }
}
else
{
    redirect("user.php", "Không tìm thấy người dùng");
}
