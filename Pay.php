    <?php 
include("./includes/header.php");
if (!isset($_SESSION['auth_user']['id'])){
    die("Từ Chối truy cập <a href='./login'>Đăng nhập ngay</a>");
}

$id = $_SESSION['auth_user']['id'];

$users = getByID("users",$id);                              
$data= mysqli_fetch_array($users);
?>;

<style>
    th,td{
        padding: 5px;
        text-align: center;
    }
    .input-number{
        width: 100%;
        font-size: 20px;
        outline: none;
        border: none;
    }
    .btn-buy{
        border: none;
        outline: none;
        font-size: 17px;
        padding: 2px 6px;
        border-radius: 2px;
        background-color: #59e1ff;
        display: inline-block;
    }
</style>

<body>
    <!-- product-detail content -->
    <div class="bg-main">
        <div class="container">
            <div class="box">
                <div class="breadcumb">
                    <a href="index.php">Trang chủ</a>
                    <span><i class='bx bxs-chevrons-right'></i></span>
                    <a href="./cart.php">Giỏ hàng của tôi</a>
                    <span><i class='bx bxs-chevrons-right'></i></span>
                    <a href="#">Thanh toán</a>
                </div>
            </div>

            <div class="box" style="padding: 0 40px">
                <div class="product-info">
                    <?php include("PayInclude.php");?>
                <br>    
                <br>
                </div>
            </div>
        </div>
    </div>
    <!-- end product-detail content -->
    <?php include("./includes/footer.php") ?>
    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/index.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src="./assets/font/jquery/jquery-3.6.1.js"></script> -->
    <script type="text/javascript" src="./assets/js/Wn3.js"></script>
</body>
    <script>
        $(document).ready(function () {
            $('.input-number').on('change', function (e) {
                if (e.target.value == 0){
                    e.target.value = 1;
                }
                const node      = $(this).parent().parent();
                const price     = parseInt(node.find('.product-price').val());
                let total_order = parseInt(e.target.value);
                let total_price = price * total_order;
                node.find('.total-price').html(total_price);
            })
        });
    </script>

<script>
$(document).ready(function () {
  $(".btn-buy").click(function (event) {
    event.preventDefault();

    const form = $("#checkoutForm");

    // Thu thập dữ liệu từ form
    var formDataArray = form.serializeArray();

    // Thêm thông tin radio vào
    const paymentMethod = $("input[name='option-payment']:checked").val();
    formDataArray.push({ name: "payment_method", value: paymentMethod === "bacs" ? 0 : 1 });

    // Chuyển đổi dữ liệu sang query string
    var formData = $.param(formDataArray);

    // Gửi request qua Ajax
    $.ajax({
      url: "./functions/ordercode.php",
      type: "POST",
      data: formData,
      success: function (response) {
        if (response.trim() == "1") {
          //alert("Đặt hàng thành công!");
          window.location.href = "cart-status.php";
        } else {
          //alert("Lỗi khi đặt hàng: " + response);
          location.reload();
        }
      },
      error: function (xhr, status, error) {
        console.error("Lỗi AJAX:", error);
      }
    });
  });
});
</script>
</html>