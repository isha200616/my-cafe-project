<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $guests = intval($_POST['guests']);
    $date = $_POST['booking_date'];
    $time = $_POST['booking_time'];
    $msg = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$phone || !$guests || !$date || !$time) {
        flash_set('error', 'Please fill all required fields.');
        header("Location: dinein.php");
        exit;
    }

    // insert
    $stmt = $pdo->prepare("INSERT INTO table_bookings 
        (name, email, phone, guests, booking_date, booking_time, message)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $guests, $date, $time, $msg]);

    flash_set('success', 'Your table has been booked successfully!');
    header("Location: dinein.php");
    exit;
}
