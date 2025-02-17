<?php
session_start();
require 'config.php';

if (!isset($_SESSION['email'])) {
    die("User not logged in.");
}
$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO documents1 (email, rc, dl, plc, ic, others) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sbbbbb", $email,
        file_get_contents($_FILES['rc']['tmp_name']),
        file_get_contents($_FILES['dl']['tmp_name']),
        file_get_contents($_FILES['plc']['tmp_name']),
        file_get_contents($_FILES['ic']['tmp_name']),
        file_get_contents($_FILES['others']['tmp_name'])
    );

    if ($stmt->execute()) {
        echo "Files uploaded successfully.";

    } else {
        echo "Error uploading files.";
    }
}
?>