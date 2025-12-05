<?php
session_start();

$name = '';
$email = '';
$message = '';
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    // For now we just simulate submission; you can later hook this to email or DB.
    if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $message !== '') {
        $submitted = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Cafe - Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/header.php'; ?>

<main class="container py-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <h1 class="mb-4 text-cozy">Contact Us</h1>
            <p class="mb-3">Have a question, suggestion, or special request? We&#39;d love to hear from you.</p>

            <?php if ($submitted): ?>
                <div class="alert alert-success">Thank you for reaching out! We&#39;ll get back to you soon.</div>
            <?php endif; ?>

            <form method="post" class="card p-4 shadow-sm rounded-4">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="4" class="form-control" required><?php echo htmlspecialchars($message); ?></textarea>
                </div>
                <button type="submit" class="btn btn-cozy-primary w-100">Send Message</button>
            </form>
        </div>
        <div class="col-lg-6">
            <h2 class="h5 mb-3">Visit Cozy Cafe</h2>
            <p class="mb-1"><strong>Address:</strong> Your Cozy Cafe address here</p>
            <p class="mb-1"><strong>Hours:</strong> 8:00 AM – 9:00 PM (Mon–Sun)</p>
            <p class="mb-3"><strong>Phone:</strong> +91-00000-00000</p>
            <p class="text-muted small">You can customize these details to match your real cafe location and timings.</p>
        </div>
    </div>
</main>

<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
