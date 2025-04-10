<?php
session_start();
include("../config/dbcon.php");
include("../functions/myfunctions.php");

if(isset($_GET['id']))
{
    $user_id = $_GET['id'];

    $query = "UPDATE users SET status = 1 WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if($result)
    {
        redirect("user.php", "Mở khóa người dùng thành công");
    }
    else
    {
        redirect("user.php", "Đã xảy ra lỗi khi mở khóa người dùng");
    }
}
else
{
    redirect("user.php", "Không tìm thấy người dùng");
}
