<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book a Table – Cozycafe</title>
</head>
<body>
<h2>Reserve Your Table</h2>

<?php if ($success = flash_get('success')): ?>
    <p style="color:green"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<?php if ($error = flash_get('error')): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="book_table.php" method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" required><br><br>

    <label>No. of Guests:</label><br>
    <input type="number" name="guests" min="1" max="20" required><br><br>

    <label>Date:</label><br>
    <input type="date" name="booking_date" required><br><br>

    <label>Time:</label><br>
    <input type="time" name="booking_time" required><br><br>

    <label>Special Request (optional):</label><br>
    <textarea name="message"></textarea><br><br>

    <button type="submit">Book Table</button>
</form>

</body>
</html>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Total: ₹<?php echo number_format($total, 2); ?></h4>
                <div>
                    <button type="submit" class="btn btn-primary me-2">Update Cart</button>
                    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </form>
    <?php endif; ?> 