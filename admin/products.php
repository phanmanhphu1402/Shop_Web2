    <?php 
include ("../admin/includes/header.php");
?>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sản phẩm</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Hình ảnh</th>
                                <th>Trạng thái</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $products= getAll("products");

                                if(mysqli_num_rows($products) >0)
                                {
                                    foreach($products as $item)
                                    {
                                    ?>
                                        <tr class="<?= $item['status'] == '1' ? 'opacity-50' : '' ?>">
                                            <td><?= $item['id'];?> </td>
                                            <td><?= $item['name'];?></td>
                                            <td>
                                                <img src="../images/<?= $item['image']; ?>" width="50px" height="50px" alt="<?= $item['name'];?>">
                                            <td>
                                                <span class="badge <?= $item['status'] == '0' ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= $item['status'] == '0' ? "Còn hàng" : "Đã ẩn" ?>
                                                </span>
                                            </td> 
                                            <td>
                                                <a href="edit-product.php?id=<?= $item['id'];?>" class="btn btn-primary">Sửa</a>                                 
                                            </td>
                                            <td>
                                                <form action="code.php" method="POST">
                                                    <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                    <button type="submit" name="delete_product_btn" class="btn btn-danger">Xóa  </button>
                                                </form>   
                                            </td>                      
                                        </tr>
                                    <?php
                                    }
                                }else
                                {
                                    echo "No records found";
                                }
                            ?>
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php include ("../admin/includes/footer.php"); ?>