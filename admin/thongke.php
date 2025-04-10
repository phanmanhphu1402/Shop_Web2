<?php
include('../config/dbcon.php');
include ("../admin/includes/header.php");
?>

<div class="container mt-4">
    <h4>Thống kê top 5 khách hàng mua nhiều nhất</h4>

    <form method="GET" class="mb-3">
        <label>Từ ngày:</label>
        <input type="date" name="from" required>
        <label>Đến ngày:</label>
        <input type="date" name="to" required>
        <button type="submit" class="btn btn-primary btn-sm">Thống kê</button>
    </form>

    <?php
    if (isset($_GET['from']) && isset($_GET['to'])) {
        $from = $_GET['from'];
        $to = $_GET['to'];

        $query = "
            SELECT u.id AS user_id, u.name, u.email, SUM(od.selling_price * od.quantity) AS total_spent
            FROM users u
            JOIN orders o ON o.user_id = u.id
            JOIN order_detail od ON od.order_id = o.id
            WHERE o.created_at BETWEEN '$from' AND '$to'
            GROUP BY u.id
            ORDER BY total_spent DESC
            LIMIT 5
        ";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($user = mysqli_fetch_assoc($result)) {
                echo "<div class='card mb-3'>
                        <div class='card-body'>
                            <h5>{$user['name']} ({$user['email']})</h5>
                            <p><strong>Tổng chi tiêu:</strong> {$user['total_spent']}đ</p>";

                // Chi tiết đơn hàng
                $user_id = $user['user_id'];
                $order_detail_query = "
                    SELECT o.id AS order_id, o.created_at,
                           SUM(od.selling_price * od.quantity) AS order_total
                    FROM orders o
                    JOIN order_detail od ON od.order_id = o.id
                    WHERE o.user_id = '$user_id' AND o.created_at BETWEEN '$from' AND '$to'
                    GROUP BY o.id
                    ORDER BY o.created_at DESC
                ";
                $orders = mysqli_query($con, $order_detail_query);

                echo "<ul>";
                while ($order = mysqli_fetch_assoc($orders)) {
                    echo "<li>Đơn hàng <a href='order-detail.php?id={$order['order_id']}'>#{$order['order_id']}</a>
                          - Ngày: {$order['created_at']} - Tổng: {$order['order_total']}đ</li>";
                }
                echo "</ul></div></div>";
            }
        } else {
            echo "<p>Không tìm thấy dữ liệu trong khoảng thời gian này.</p>";
        }
    }
    ?>

</div>

<?php include('includes/footer.php'); ?>
