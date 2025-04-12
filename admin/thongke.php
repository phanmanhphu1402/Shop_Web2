<?php
include('../config/dbcon.php');
include ("../admin/includes/header.php");
?>

<div class="container mt-4">
    <h4>Thống kê top 5 khách hàng mua nhiều nhất</h4>

    <form method="GET" class="mb-3">
        <label>Từ ngày:</label>
        <input type="date" name="from" value="<?= isset($_GET['from']) ? $_GET['from'] : '' ?>">
        <label>Đến ngày:</label>
        <input type="date" name="to" value="<?= isset($_GET['to']) ? $_GET['to'] : '' ?>">
        <button type="submit" class="btn btn-primary btn-sm">Thống kê</button>
    </form>

    <?php
    $from = isset($_GET['from']) ? mysqli_real_escape_string($conn, $_GET['from']) : null;
    $to = isset($_GET['to']) ? mysqli_real_escape_string($conn, $_GET['to']) : null;

    $whereClause = "";

    if ($from && $to) {
        if ($from > $to) {
            echo "<p class='text-danger'>Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.</p>";
            include('includes/footer.php');
            exit;
        }
        $whereClause = "WHERE o.created_at BETWEEN '$from' AND '$to'";
    } elseif ($from) {
        $whereClause = "WHERE o.created_at >= '$from'";
    } elseif ($to) {
        $whereClause = "WHERE o.created_at <= '$to'";
    }

    $query = "
        SELECT u.id AS user_id, u.name, u.email, SUM(od.selling_price * od.quantity) AS total_spent
        FROM users u
        JOIN orders o ON o.user_id = u.id
        JOIN order_detail od ON od.order_id = o.id
        $whereClause
        GROUP BY u.id
        ORDER BY total_spent DESC
        LIMIT 5
    ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            echo "<div class='card mb-3'>
                    <div class='card-body'>
                        <h5>{$user['name']} ({$user['email']})</h5>
                        <p><strong>Tổng chi tiêu:</strong> " . number_format($user['total_spent'], 0, ',', '.') . "₫</p>";

            // Chi tiết đơn hàng của từng user
            $user_id = $user['user_id'];
            $order_detail_query = "
                SELECT o.id AS order_id, o.created_at,
                       SUM(od.selling_price * od.quantity) AS order_total
                FROM orders o
                JOIN order_detail od ON od.order_id = o.id
                WHERE o.user_id = '$user_id' " . ($whereClause ? "AND " . substr($whereClause, 6) : "") . "
                GROUP BY o.id
                ORDER BY o.created_at DESC
            ";
            $orders = mysqli_query($conn, $order_detail_query);

            echo "<ul>";
            while ($order = mysqli_fetch_assoc($orders)) {
                echo "<li> <a href='order-detail.php?id_order={$order['order_id']}'>Đơn hàng#{$order['order_id']}</a>
                      - Ngày: {$order['created_at']} - Tổng: " . number_format($order['order_total'], 0, ',', '.') . "₫</li>";
            }
            echo "</ul></div></div>";
        }
    } else {
        echo "<p>Không tìm thấy dữ liệu trong khoảng thời gian này.</p>";
    }
    ?>

</div>

<?php include('includes/footer.php'); ?>
