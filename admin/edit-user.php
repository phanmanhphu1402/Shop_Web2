<?php 
include ("../admin/includes/header.php");
?>

<body>
<div class="container-fluid">   
    <div class="row">
        <div class="col-md-12">
            <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $user = getByID("users", $id);

                if(mysqli_num_rows($user) > 0)
                {
                    $data = mysqli_fetch_array($user);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Chỉnh sửa người dùng</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="user_id" value="<?= $data['id'] ?>">
                                        <label for=""><b>Tên</b></label>
                                        <input type="text" name="name" required value="<?= $data['name'] ?>" placeholder="Nhập tên người dùng" class="form-control"> 
                                    </div>                               

                                    <div class="col-md-12">
                                        <br>
                                        <label for=""><b>Email</b></label>
                                        <input type="email" name="email" required value="<?= $data['email'] ?>" placeholder="Nhập email" class="form-control">
                                    </div>                              

                                    <div class="col-md-12">
                                        <br>
                                        <label for=""><b>Số điện thoại</b></label>
                                        <input type="text" name="phone" required value="<?= $data['phone'] ?>" placeholder="Nhập số điện thoại" class="form-control">
                                    </div>                              

                                    <div class="col-md-12">
                                        <br>
                                        <label for=""><b>Địa chỉ</b></label>
                                        <input type="text" name="address" required value="<?= $data['address'] ?>" placeholder="Nhập địa chỉ" class="form-control">
                                    </div>  

                                    <div class="col-md-12">
                                        <br>
                                        <label for=""><b>Mật khẩu mới (nếu muốn đổi)</b></label>
                                        <input type="password" name="password" placeholder="Nhập mật khẩu mới (để trống nếu không đổi)" class="form-control">
                                    </div>

                                    <div class="col-md-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="update_user_btn">Cập nhật</button>
                                        <a href="user.php" class="btn btn-secondary">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<h5>Không tìm thấy người dùng</h5>";
                }
            } else {
                echo "<h5>Thiếu ID người dùng trên URL</h5>";
            }
            ?>
        </div>
    </div>
</div>
</body>

<?php include ("../admin/includes/footer.php"); ?>
