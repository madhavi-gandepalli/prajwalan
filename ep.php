<?php
session_start(); // Start session at the very top

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hackthon";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
//if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
   // header("Location: vdocs.php"); // Redirect to login page if session is missing
   //exit();
//}
$_SESSION['email']='madhavigandepalli23@gmail.com';

// Get the user's email from the session
$email = urlencode($_SESSION['email']); 
$qr_url = "http://localhost/triveni.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        #qrcode { margin-top: 20px; display: inline-block; }
    </style>
</head>
<body>

    <h2>Your QR Code</h2>
    <p>Scan this QR code to view your uploaded vehicle documents.</p>
    
    <div id="qrcode"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var qr_url = "<?php echo $qr_url; ?>";
            new QRCode(document.getElementById("qrcode"), {
                text: qr_url,
                width: 200,
                height: 200
            });
        });
    </script>

    <p><a href="triveni.php">Click here to view documents</a></p>

</body>
</html>
