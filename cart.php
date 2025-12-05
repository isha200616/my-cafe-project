<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$conn = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $productId = (int)($_POST['product_id'] ?? 0);
        $qty = max(1, (int)($_POST['quantity'] ?? 1));

        $stmt = $conn->prepare('SELECT id, name, price FROM products WHERE id = ? AND is_active = 1 LIMIT 1');
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($product = $result->fetch_assoc()) {
            if (!isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] = [
                    'name' => $product['name'],
                    'price' => (float)$product['price'],
                    'quantity' => 0,
                ];
            }
            $_SESSION['cart'][$productId]['quantity'] += $qty;
        }
        $stmt->close();
    } elseif ($action === 'update') {
        foreach (($_POST['quantities'] ?? []) as $id => $qty) {
            $id = (int)$id;
            $qty = (int)$qty;
            if ($qty <= 0) {
                unset($_SESSION['cart'][$id]);
            } elseif (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] = $qty;
            }
        }
    } elseif ($action === 'remove') {
        $productId = (int)($_POST['product_id'] ?? 0);
        unset($_SESSION['cart'][$productId]);
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
    }
}

$conn->close();

$cart = $_SESSION['cart'];
$total = 0.0;
foreach ($cart as $id => $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Cafe - My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/header.php'; ?>
<main class="container py-5">
    <h1 class="mb-4 text-cozy">My Cart</h1>

    <?php if (!$cart): ?>
        <div class="alert alert-info">Your cart is empty. Browse our <a href="menu.php">menu</a> to add items.</div>
    <?php else: ?>
        <form method="post" class="card p-4 shadow-sm mb-3">
            <input type="hidden" name="action" value="update">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="width: 120px;">Price</th>
                            <th style="width: 120px;">Quantity</th>
                            <th style="width: 120px;">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $id => $item):
                            $lineTotal = $item['price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" name="quantities[<?php echo (int)$id; ?>]" value="<?php echo (int)$item['quantity']; ?>" min="0" class="form-control form-control-sm">
                            </td>
                            <td>₹<?php echo number_format($lineTotal, 2); ?></td>
                            <td>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo (int)$id; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <strong>Grand Total: </strong>₹<?php echo number_format($total, 2); ?>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-outline-cozy">Update Cart</button>
                </div>
            </div>
        </form>
        <form method="post" class="d-flex justify-content-between align-items-center">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="btn btn-link text-danger p-0">Clear cart</button>
            <a href="checkout.php" class="btn btn-cozy-primary">Proceed to Checkout</a>
        </form>
    <?php endif; ?>
</main>
<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
