<html>
    <head>
        <style>
            body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    text-align: center;
    padding: 50px;
}

/* Success Message Container */
.success-container {
    background: white;
    padding: 30px;
    max-width: 400px;
    margin: auto;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #28a745;
    font-size: 24px;
}

p {
    color: #333;
    font-size: 16px;
}

/* Button Styles */
.btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

/* Error Message */
.error-msg {
    color: red;
    font-size: 18px;
    font-weight: bold;
    margin-top: 20px;
}

</style>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hackthon";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate form inputs
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    // Check if name is empty
    if (empty($name)) {
        die("Error: Name cannot be empty!");
    }

    // Prepare and execute the INSERT statement
    $stmt = $conn->prepare("INSERT INTO vdstorage (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $pass);
    
    if ($stmt->execute()) {
        echo '<div class="success-container">
                <h1>🎉 Registration Successful! 🎉</h1>
                <p>Thank you, <strong>' . htmlspecialchars($name) . '</strong>, for registering.</p>
                <p>You can now log in to your account.</p>
                <a href="vdocs.php" class="btn">Go to Login</a>
              </div>';
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    die("Error: Missing form fields.");
}

// Close the connection
$conn->close();
?>
</body>
</html>
