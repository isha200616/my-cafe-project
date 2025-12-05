<?php
session_start();
require_once __DIR__ . '/auth.php';
require_login();
require_once __DIR__ . '/db.php';

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    header('Location: cart.php');
    exit;
}

$errors = [];
$note = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid form token. Please refresh and try again.';
    } else {
        $note = trim($_POST['customer_note'] ?? '');

        $total = 0.0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if ($total <= 0) {
            $errors[] = 'Your cart is empty.';
        }

        if (!$errors) {
            $conn = get_db_connection();
            $conn->begin_transaction();
            try {
                $status = 'pending';
                $userId = (int)$_SESSION['user_id'];
                $stmt = $conn->prepare('INSERT INTO orders (user_id, total_amount, status, customer_note, created_at) VALUES (?, ?, ?, ?, NOW())');
                $stmt->bind_param('idss', $userId, $total, $status, $note);
                $stmt->execute();
                $orderId = $stmt->insert_id;
                $stmt->close();

                $itemStmt = $conn->prepare('INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)');
                foreach ($cart as $productId => $item) {
                    $pid = (int)$productId;
                    $qty = (int)$item['quantity'];
                    $price = (float)$item['price'];
                    $itemStmt->bind_param('iiid', $orderId, $pid, $qty, $price);
                    $itemStmt->execute();
                }
                $itemStmt->close();

                $conn->commit();
                $_SESSION['cart'] = [];
                header('Location: order_confirm.php?order_id=' . $orderId);
                exit;
            } catch (Throwable $e) {
                $conn->rollback();
                $errors[] = 'Could not place order. Please try again.';
            }
            $conn->close();
        }
    }
}

$csrf = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Cafe - Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/header.php'; ?>
<main class="container py-5">
    <h1 class="mb-4 text-cozy">Checkout</h1>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-6">
            <h2 class="h5 mb-3">Your details</h2>
            <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></p>
            <p class="text-muted small mb-3">Well use your account details for contact if needed.</p>

            <form method="post" class="card p-4 shadow-sm rounded-4">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf); ?>">
                <div class="mb-3">
                    <label class="form-label">Pickup notes (optional)</label>
                    <textarea name="customer_note" rows="3" class="form-control" placeholder="e.g., No sugar, extra hot."><?php echo htmlspecialchars($note); ?></textarea>
                </div>
                <button type="submit" class="btn btn-cozy-primary w-100">Place Order</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2 class="h5 mb-3">Order summary</h2>
            <div class="card p-3 shadow-sm">
                <ul class="list-group list-group-flush mb-3">
                    <?php $total = 0.0; foreach ($cart as $item):
                        $lineTotal = $item['price'] * $item['quantity'];
                        $total += $lineTotal;
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div><?php echo htmlspecialchars($item['name']); ?></div>
                                <small class="text-muted">Qty: <?php echo (int)$item['quantity']; ?></small>
                            </div>
                            <div>₹<?php echo number_format($lineTotal, 2); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>₹<?php echo number_format($total, 2); ?></strong>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
