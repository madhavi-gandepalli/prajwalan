<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer (Ensure this is in your 'vendor' directory)
require 'vendor/autoload.php';

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "hackthon";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch documents expiring in the next 10 days
$query = "
    SELECT email, vehicle_number, rc_expiry, dl_expiry, plc_expiry, ic_expiry, others_expiry
    FROM vehicle_documents
    WHERE 
        rc_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
        OR dl_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
        OR plc_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
        OR ic_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
        OR others_expiry BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
";

$result = $conn->query($query);

// Loop through each result and send notifications
while ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $vehicle_number = $row['vehicle_number'];
    $expiringDocs = getExpiringDocuments($row);

    // If there are expiring documents, send an email
    if (!empty($expiringDocs)) {
        sendExpiryNotification($email, $vehicle_number, $expiringDocs);
    }
}

$conn->close();

// Function to check for expiring documents
function getExpiringDocuments($row) {
    $expiringDocs = [];
    $documents = [
        'rc_expiry' => 'RC',
        'dl_expiry' => 'Driving License',
        'plc_expiry' => 'Pollution Certificate',
        'ic_expiry' => 'Insurance Certificate',
        'others_expiry' => 'Other Documents'
    ];

    foreach ($documents as $key => $label) {
        if (!empty($row[$key]) && strtotime($row[$key]) <= strtotime("+10 days")) {
            $expiringDocs[] = "$label (Expiry Date: " . $row[$key] . ")";
        }
    }

    return $expiringDocs;
}

// Function to send email notification
function sendExpiryNotification($email, $vehicle_number, $expiringDocs) {
    $mail = new PHPMailer(true);
    try {
        // SMTP settings (use your own email SMTP)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server (change accordingly)
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME'); // Use environment variables for security
        $mail->Password = getenv('SMTP_PASSWORD'); // Use environment variables for security
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('madhavigandepalli23@gmail.com', 'Vehicle Docs Reminder');
        $mail->addAddress($email);
        $mail->Subject = "🚗 Vehicle Document Expiry Reminder";
        
        // Email body
        $body = "<h3>Hello,</h3>
                 <p>Your vehicle <strong>$vehicle_number</strong> has the following documents expiring soon:</p>
                 <ul>";
        foreach ($expiringDocs as $doc) {
            $body .= "<li>$doc</li>";
        }
        $body .= "</ul>
                 <p>Please renew them before the expiry date to avoid any issues.</p>
                 <p>Regards,<br><strong>V-Docs Team</strong></p>";

        $mail->isHTML(true);
        $mail->Body = $body;

        // Send email
        $mail->send();
        echo "Notification sent to $email successfully!<br>";
    } catch (Exception $e) {
        echo "Failed to send email to $email. Mailer Error: {$mail->ErrorInfo}<br>";
    }
}
?>
