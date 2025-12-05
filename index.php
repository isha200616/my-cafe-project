<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Cafe - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <li><a href="/Cozycafe/dinein.php">Dine-In Reservation</a></li>

</head>
<body>
<?php include 'partials/header.php'; ?>

<main>
    <!-- Hero section -->
    <section class="cozy-hero py-5">
        <div class="container py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="badge rounded-pill cozy-badge mb-3">Fresh • Warm • Handmade</span>
                    <h1 class="display-4 fw-bold text-cozy mb-3">Welcome to Cozy Cafe</h1>
                    <p class="lead text-muted mb-4">
                        Start your day with a rich cappuccino, linger over a book with masala chai,
                        or grab a freshly baked croissant on the go.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="menu.php" class="btn btn-cozy-primary btn-lg">Browse Our Menu</a>
                        <a href="login.php" class="btn btn-outline-cozy btn-lg">Login / Sign Up</a>
                    </div>
                    <p class="mt-3 mb-0 text-muted small">Open today: <strong>8:00 AM – 9:00 PM</strong></p>
                </div>
                <div class="col-lg-6">
                    <div class="hero-card p-4 p-md-5 rounded-4 shadow-lg cozy-hero-card">
                        <h2 class="h4 mb-3">Today at Cozy Cafe</h2>
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2">• Baristas choice: <strong>Vanilla Latte</strong> with silky microfoam.</li>
                            <li class="mb-2">• Fresh from the oven: <strong>Butter Croissant</strong> &amp; <strong>Chocolate Brownie</strong>.</li>
                            <li class="mb-0">• Chill out with our slow-brewed <strong>Cold Brew</strong>.</li>
                        </ul>
                        <p class="text-muted small mb-0">Order online now and pick up when its convenient for you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Highlights section -->
    <section class="container py-5">
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="h3 text-cozy mb-2">Why youll love Cozy Cafe</h2>
                <p class="text-muted mb-0">A small space with big flavors and a warm, welcoming atmosphere.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="feature-icon-circle mb-3">
                            <span class="feature-icon">☕</span>
                        </div>
                        <h3 class="h5 mb-2">Handcrafted Drinks</h3>
                        <p class="text-muted mb-0">From cappuccinos to masala chai, every cup is brewed to order by our baristas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="feature-icon-circle mb-3">
                            <span class="feature-icon">🥐</span>
                        </div>
                        <h3 class="h5 mb-2">Fresh Bakes Daily</h3>
                        <p class="text-muted mb-0">Enjoy warm croissants, brownies, and light snacks baked in small batches.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="feature-icon-circle mb-3">
                            <span class="feature-icon">🛋️</span>
                        </div>
                        <h3 class="h5 mb-2">Cozy Corners</h3>
                        <p class="text-muted mb-0">Comfortable seating, warm lighting, and free Wi‑Fi for work, study, or relaxed chats.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call-to-action strip -->
    <section class="cozy-cta-strip py-4">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div>
                <h2 class="h5 mb-1 text-light">Ready for a cozy break?</h2>
                <p class="mb-0 text-light-50 small">Order your favorites now and well have them ready when you arrive.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="menu.php" class="btn btn-light">Order from Menu</a>
                <a href="contact.php" class="btn btn-outline-light">Contact Us</a>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
