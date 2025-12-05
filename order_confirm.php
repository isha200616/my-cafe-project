<?php
session_start();
require_once __DIR__ . '/auth.php';
require_login();
require_once __DIR__ . '/db.php';

$orderId = (int)($_GET['order_id'] ?? 0);
$order = null;
$items = [];

if ($orderId > 0) {
    $conn = get_db_connection();
    $userId = (int)$_SESSION['user_id'];

    $stmt = $conn->prepare('SELECT id, total_amount, status, customer_note, created_at FROM orders WHERE id = ? AND user_id = ? LIMIT 1');
    $stmt->bind_param('ii', $orderId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if ($order) {
        $itemStmt = $conn->prepare('SELECT oi.quantity, oi.unit_price, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
        $itemStmt->bind_param('i', $orderId);
        $itemStmt->execute();
        $itemResult = $itemStmt->get_result();
        while ($row = $itemResult->fetch_assoc()) {
            $items[] = $row;
        }
        $itemStmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Cafe - Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/header.php'; ?>
<main class="container py-5">
    <h1 class="mb-4 text-cozy">Order Confirmation</h1>

    <?php if (!$order): ?>
        <div class="alert alert-warning">We couldnt find that order. Please check your orders or place a new one from the <a href="menu.php">menu</a>.</div>
    <?php else: ?>
        <div class="card p-4 shadow-sm mb-4">
            <h2 class="h5 mb-3">Thank you for your order!</h2>
            <p class="mb-1">Order ID: <strong>#<?php echo (int)$order['id']; ?></strong></p>
            <p class="mb-1">Placed on: <?php echo htmlspecialchars($order['created_at']); ?></p>
            <p class="mb-3">Status: <span class="badge bg-success text-uppercase"><?php echo htmlspecialchars($order['status']); ?></span></p>

            <h3 class="h6 mt-3 mb-2">Items</h3>
            <ul class="list-group list-group-flush mb-3">
                <?php foreach ($items as $item):
                    $lineTotal = $item['unit_price'] * $item['quantity'];
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div><?php echo htmlspecialchars($item['name']); ?></div>
                            <small class="text-muted">Qty: <?php echo (int)$item['quantity']; ?> @ ₹<?php echo number_format($item['unit_price'], 2); ?></small>
                        </div>
                        <div>₹<?php echo number_format($lineTotal, 2); ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="d-flex justify-content-between">
                <strong>Total Paid at Cafe</strong>
                <strong>₹<?php echo number_format($order['total_amount'], 2); ?></strong>
            </div>

            <?php if (!empty($order['customer_note'])): ?>
                <p class="mt-3 mb-0"><strong>Your note:</strong> <?php echo htmlspecialchars($order['customer_note']); ?></p>
            <?php endif; ?>
        </div>

        <a href="menu.php" class="btn btn-cozy-primary">Back to Menu</a>
    <?php endif; ?>
</main>
<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
