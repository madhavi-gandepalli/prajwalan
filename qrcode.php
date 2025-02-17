/* config.php - Database Connection */
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "vdocs";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

/* login.php */
<?php
session_start();
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $stmt = $conn->prepare("SELECT email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_email'] = $row['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found.";
    }
}
?>

/* upload.php */
<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_email'])) { die("User not logged in."); }
$email = $_SESSION['user_email'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO documents1 (email, rc, dl, plc, ic, others) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sbbbbb", $email, file_get_contents($_FILES['rc']['tmp_name']), file_get_contents($_FILES['dl']['tmp_name']), file_get_contents($_FILES['plc']['tmp_name']), file_get_contents($_FILES['ic']['tmp_name']), file_get_contents($_FILES['others']['tmp_name']));
    if ($stmt->execute()) {
        echo "Files uploaded successfully.";
    } else {
        echo "Error uploading files.";
    }
}
?>

/* retrieve.php */
<?php
session_start();
require 'config.php';
if (!isset($_GET['email'])) { die("No email provided."); }
$email = $_GET['email'];
$stmt = $conn->prepare("SELECT rc, dl, plc, ic, others FROM documents1 WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    echo "<h2>Documents for $email</h2>";
    echo "<p>RC: <a href='view.php?file=" . urlencode(base64_encode($row['rc'])) . "'>View</a></p>";
}
?>

/* generate_qr.php */
<?php
session_start();
require 'phpqrcode/qrlib.php';
if (!isset($_SESSION['user_email'])) { die("User not logged in."); }
$email = $_SESSION['user_email'];
$url = "https://yourwebsite.com/retrieve.php?email=" . urlencode($email);
$qr_file = "qrcodes/" . md5($email) . ".png";
QRcode::png($url, $qr_file, QR_ECLEVEL_L, 6);
echo "<img src='$qr_file' alt='QR Code'>";
?>

/* dashboard.php */
<?php
session_start();
if (!isset($_SESSION['user_email'])) { die("Please log in first."); }
$email = $_SESSION['user_email'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($email); ?></h1>
    <img src="generate_qr.php" alt="Your QR Code">
</body>
</html>
