<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <img src="./images/logo.jpg" alt="TUIXIN Logo" class="img-fluid" style="max-height: 50px; width: auto;">
                        </div>
                        <div class="footer-contact">
                            <h4>Thông tin liên hệ</h4>
                            <ul class="contact-list">
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>273 Đ. An D. Vương, Phường 3, Quận 5, Thành phố Hồ Chí Minh</span>
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i>
                                    <a href="tel:0838338637">(083) 8338637</a>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:tuixin@mail.com">tuixin@mail.com</a>
                                </li>
                                <li>
                                    <i class="fas fa-clock"></i>
                                    <span>8:00 - 18:00 Thứ 2 - Chủ Nhật</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <h4 class="widget-title">Danh mục</h4>
                        <ul class="widget-links">
                            <li><a href="./products.php?type=balo">Balo</a></li>
                            <li><a href="./products.php?type=tui-xach">Túi xách</a></li>
                            <li><a href="./products.php?type=vi-cao-cap">Ví cao cấp</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <h4 class="widget-title">Thông tin và chính sách</h4>
                        <ul class="widget-links">
                            <li><a href="#">Trả góp 0%</a></li>
                            <li><a href="#">Liên hệ chúng tôi</a></li>
                            <li><a href="#">Chương trình ưu đãi thu cũ đổi mới</a></li>
                            <li><a href="#">Chính sách bảo hành & đổi trả sản phẩm</a></li>
                            <li><a href="#">Chính sách bảo mật thông tin</a></li>
                            <li><a href="#">Điều khoản sử dụng</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <h4 class="widget-title">Đăng ký nhận tin</h4>
                        <p>Đăng ký để nhận thông tin mới nhất về sản phẩm và khuyến mãi</p>
                        <form class="subscribe-form">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email của bạn">
                                <button type="submit" class="btn-subscribe"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                        <div class="social-media">
                            <h4>Kết nối với chúng tôi</h4>
                            <ul class="social-list">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> TUIXIN. Tất cả các quyền được bảo lưu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fas fa-arrow-up"></i>
</a>

<!-- Link Font Awesome if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />


<!-- Alertify JS -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    <?php if (isset($_SESSION['message'])) { ?>
        alertify.set('notifier', 'position', 'top-right');
        alertify.success('<?= $_SESSION['message'] ?>');
    <?php unset($_SESSION['message']);
    } ?>

    // Back to top functionality
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#backToTop').addClass('show');
            } else {
                $('#backToTop').removeClass('show');
            }
        });

        $('#backToTop').click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 300);
        });
    });
</script>