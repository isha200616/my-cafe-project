<?php
session_start();
require_once __DIR__ . '/db.php';

// Get DB connection
$conn = get_db_connection();

// FIXED — use correct table name menu_items + remove is_active if your table doesn't have it
$sql = "SELECT id, name, description, price, category FROM menu_items ORDER BY category, name";

$result = $conn->query($sql);

// Error debugging
if (!$result) {
    die("SQL ERROR: " . $conn->error);
}

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$conn->close();

// Group items by category
$grouped = [];
foreach ($products as $p) {
    $grouped[$p['category']][] = $p;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Cafe - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/header.php'; ?>

<main class="container py-5">
    <h1 class="mb-4 text-cozy">Our Menu</h1>
    <p class="text-muted mb-4">Browse our selection and add items to your cart.</p>

    <?php if (!$grouped): ?>
        <p>No menu items found. Add items in phpMyAdmin → menu_items table.</p>
    <?php endif; ?>

    <?php foreach ($grouped as $category => $items): ?>
        <h2 class="h4 mt-4 mb-3"><?php echo htmlspecialchars($category); ?></h2>
        <div class="row g-3">
            <?php foreach ($items as $item): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h3 class="h5 card-title"><?php echo htmlspecialchars($item['name']); ?></h3>

                            <p class="card-text text-muted flex-grow-1">
                                <?php echo htmlspecialchars($item['description']); ?>
                            </p>

                            <div class="d-flex justify-content-between mt-3 align-items-center">
                                <span class="fw-bold">₹<?php echo number_format($item['price'], 2); ?></span>

                                <form action="cart.php" method="post" class="d-flex">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="1" min="1"
                                           class="form-control form-control-sm me-2" style="width: 60px;">
                                    <button class="btn btn-sm btn-cozy-primary">Add</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

</main>

<?php include 'partials/footer.php'; ?>
</body>
</html>
