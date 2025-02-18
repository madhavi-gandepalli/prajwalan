<?php
session_start();
require 'phpqrcode/qrlib.php';

if (!isset($_SESSION['user_email'])) {
    die("User not logged in.");
}

$email = $_SESSION['user_email'];
$url = "https://yourwebsite.com/retrieve.php?email=" . urlencode($email);
$qr_file = "qrcodes/" . md5($email) . ".png";

QRcode::png($url, $qr_file, QR_ECLEVEL_L, 6);
echo "<img src='$qr_file' alt='QR Code'>";
?>