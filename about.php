<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Cafe - About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/header.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4 text-cozy">About Cozy Cafe</h1>
            <p class="lead">Cozy Cafe is your neighborhood corner for slow mornings, quick catch-ups, and everything in between.</p>
            <p>We believe coffee should be warm, comforting, and crafted with care. That&#39;s why we handpick our beans, bake our pastries in small batches, and design every cup to feel like a small break from the rush outside.</p>
            <p>Whether you&#39;re here to study, work, or unwind with friends, Cozy Cafe offers a relaxed atmosphere, friendly baristas, and a menu full of comforting favorites.</p>
            <h2 class="h4 mt-4">Our promise</h2>
            <ul>
                <li>Freshly brewed coffee and tea throughout the day.</li>
                <li>House-baked pastries and light snacks.</li>
                <li>A warm, welcoming space for everyone.</li>
            </ul>
        </div>
    </div>
</main>

<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
