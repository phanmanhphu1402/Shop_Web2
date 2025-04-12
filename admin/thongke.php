<?php
include('../config/dbcon.php');
include("../admin/includes/header.php");
?>

<div class="container mt-4">
    <div class="card bg-white shadow-sm mb-4 p-4">
        <h4 class="mb-3 fw-bold text-danger">
            📊 Thống kê top 5 khách hàng mua nhiều nhất
        </h4>

        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-auto">
            <label class="bg-light px-2 py-1 rounded d-inline-block">Từ ngày:</label>
                <input type="date" class="form-control" name="from" value="<?= isset($_GET['from']) ? $_GET['from'] : '' ?>">
            </div>
            <div class="col-md-auto">
            <label class="bg-light px-2 py-1 rounded d-inline-block">Đến ngày:</label>
                <input type="date" class="form-control bg-li" name="to" value="<?= isset($_GET['to']) ? $_GET['to'] : '' ?>">
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-danger mt-4">
                    🔍 THỐNG KÊ
                </button>
            </div>
        </form>
    </div>

    <?php
    $from = isset($_GET['from']) ? mysqli_real_escape_string($conn, $_GET['from']) : null;
    $to = isset($_GET['to']) ? mysqli_real_escape_string($conn, $_GET['to']) : null;
    $whereClause = "";

    if ($from && $to) {
        if ($from > $to) {
            echo "<div class='alert alert-warning'>❌ Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.</div>";
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

    if (mysqli_num_rows($result) > 0): ?>
        <?php while ($user = mysqli_fetch_assoc($result)): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</h5>
                    <p><strong class="text-muted">Tổng chi tiêu:</strong> <span class="text-danger fw-bold"><?= number_format($user['total_spent'], 0, ',', '.') ?>₫</span></p>

                    <ul class="list-unstyled ps-3">
                        <?php
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
                        while ($order = mysqli_fetch_assoc($orders)):
                        ?>
                            <li class="mb-1">
                                🧾 <a href='order-detail.php?id_order=<?= $order['order_id'] ?>'>
                                    Đơn hàng #<?= $order['order_id'] ?></a>
                                - 📅 <?= $order['created_at'] ?>
                                - 💰 <strong><?= number_format($order['order_total'], 0, ',', '.') ?>₫</strong>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">🔍 Không tìm thấy dữ liệu trong khoảng thời gian này.</div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>