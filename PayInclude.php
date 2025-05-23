<link rel="stylesheet" href="./assets/font/fontawesome-free-6.2.0-web/css/all.css">
<link rel="stylesheet" href="./assets/css/Pay.css">

<form id="checkoutForm" method="post" action="ordercode.php">
    <input type="hidden" name="buy_product" value="true">

    <div class="slider">
        <!-- LEFT FORM -->
        <div class="form-left">
            <div class="information">
                <div class="information-bill">
                    <h3 class="billing">Thông tin thanh toán</h3>
                    <div class="input-information">
                        <p class="name">
                            <label for="name">Họ và tên <span style="color:red">*</span></label>
                            <span>
                                <input class="form-control" id="name" required type="text" name="name" value="<?= $data['name'] ?>"><br>
                            </span>
                        </p>

                        <p class="address">
                            <label for="address">Địa chỉ <span style="color:red">*</span></label>
                            <span>
                                <input class="form-control" id="address" required type="text" name="address" value="<?= $data['address'] ?>"><br>
                            </span>
                        </p>

                        <p class="phone-number">
                            <label for="phone">Số điện thoại <span style="color:red">*</span></label>
                            <span>
                                <input class="form-control" id="phone" required type="text" name="phone" value="<?= $data['phone'] ?>"><br>
                            </span>
                        </p>

                        <p class="email-address">
                            <label for="email">Địa chỉ Email <span style="color:red">*</span></label>
                            <span>
                                <input readonly class="form-control" id="email" type="text" name="email" value="<?= $data['email'] ?>"><br>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="addtional-fill">
                    <h3>Thông tin bổ sung</h3>
                    <p class="order-option">
                        <label for="order_comments">Ghi chú đặt hàng <span class="optional">(tùy chọn)</span></label>
                        <span>
                            <textarea class="input-text" id="order_comments" name="addtional" placeholder="Ghi chú đặt hàng, ví dụ, thời gian hoặc địa điểm giao hàng chi tiết hơn." rows="2" cols="5"></textarea>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT ORDER REVIEW -->
        <div class="form-right">
            <div class="order">
                <h3 class="your-oder">Đơn hàng của bạn</h3>
                <div class="oder-review">
                    <table class="product-provisinal">
                        <thead>
                            <tr>
                                <th class="product-name">Sản phẩm</th>
                                <th class="product-total">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $products = getMyOrders();
                            $total_price = 0;
                            if (mysqli_num_rows($products) > 0) {
                                foreach ($products as $product) {
                                    $product_total = $product['selling_price'] * $product['quantity'];
                                    $total_price += $product_total;
                            ?>
                                    <tr class="pro-item">
                                        <td class="product-name">
                                            <?= $product['name'] ?> × <?= $product['quantity'] ?>
                                        </td>
                                        <td class="product-total">
                                            <span class="price-amount"><?= $product_total ?> <span class="price-currencySymbol">₫</span></span>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="cart-subtotal">
                                <th>Thuế (VAT)</th>
                                <td><span class="price-amount">0 <span class="price-currencySymbol">₫</span></span></td>
                            </tr>
                            <tr class="cart-subtotal">
                                <th>Tạm tính</th>
                                <td><span class="price-amount"><?= $total_price ?> <span class="price-currencySymbol">₫</span></span></td>
                            </tr>
                            <tr class="order-total">
                                <th>Tổng</th>
                                <td><strong><span class="price-amount"><?= $total_price ?> <span class="price-currencySymbol">₫</span></span></strong></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- PAYMENT METHOD -->
                    <div class="payment">
                        <ul class="payment-list">
                            <li class="payment-bank">
                                <input type="radio" id="payment_method_bacs" checked name="option-payment" value="bacs">
                                <label for="payment_method_bacs">Chuyển khoản ngân hàng</label>
                                <div class="payment-text">
                                    <p>Thực hiện thanh toán vào tài khoản ngân hàng của chúng tôi. Đơn hàng sẽ được giao sau khi thanh toán hoàn tất.</p>
                                </div>
                            </li>
                            <li class="payment-cash">
                                <input type="radio" id="payment_method_cod" value="cod" name="option-payment">
                                <label for="payment_method_cod">Thanh toán khi giao hàng (COD)</label>
                                <div class="payment-text">
                                    <p>Thanh toán khi giao hàng</p>
                                </div>
                            </li>
                        </ul>

                        <!-- SUBMIT BUTTON -->
                        <div class="btn-order">
                            <button class="btn-order-click btn-buy" type="submit" style="float: right;">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
