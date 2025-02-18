<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "hackthon");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Print POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Check if all required fields are set
    if (isset($_POST['email'], $_POST['vehicle_number'], $_POST['rc_expiry'], $_POST['dl_expiry'], $_POST['plc_expiry'], $_POST['ic_expiry'], $_POST['others_expiry'])) {
        
        // Trim and sanitize input values
        $email = trim($_POST['email']);
        $vehicle_number = trim($_POST['vehicle_number']);
        $rc_expiry = $_POST['rc_expiry'];
        $dl_expiry = $_POST['dl_expiry'];
        $plc_expiry = $_POST['plc_expiry'];
        $ic_expiry = $_POST['ic_expiry'];
        $others_expiry = $_POST['others_expiry'];

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO vehicle_documents (email, vehicle_number, rc_expiry, dl_expiry, plc_expiry, ic_expiry, others_expiry) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $email, $vehicle_number, $rc_expiry, $dl_expiry, $plc_expiry, $ic_expiry, $others_expiry);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "<p style='color:green;'>✅ Data inserted successfully!</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Vehicle Documents</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { width: 50%; margin: auto; background: #f4f4f4; padding: 20px; border-radius: 8px; }
        label { display: block; margin: 10px 0 5px; }
        input { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { background: #28a745; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>

<h2 align="center">Insert Vehicle Documents Expiry Dates</h2>

<!-- Form for inserting data -->
<form method="POST" action="">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Vehicle Number:</label>
    <input type="text" name="vehicle_number" required>

    <label>RC Expiry Date:</label>
    <input type="date" name="rc_expiry" required>

    <label>Driving License Expiry Date:</label>
    <input type="date" name="dl_expiry" required>

    <label>Pollution Certificate Expiry Date:</label>
    <input type="date" name="plc_expiry" required>

    <label>Insurance Certificate Expiry Date:</label>
    <input type="date" name="ic_expiry" required>

    <label>Other Documents Expiry Date:</label>
    <input type="date" name="others_expiry" required>

    <button type="submit">Submit</button>
</form>

</body>
</html>
