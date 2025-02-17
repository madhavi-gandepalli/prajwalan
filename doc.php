<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hackthon");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate file type and size
function validate_file($file) {
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
    $max_size = 5 * 1024 * 1024; // 5 MB

    if (!in_array($file['type'], $allowed_types)) {
        return "Invalid file type. Allowed types are: PDF, JPG, PNG, JPEG.";
    }

    if ($file['size'] > $max_size) {
        return "File size exceeds the limit of 5 MB.";
    }

    return true;
}

// Check if form is submitted and files are uploaded
if (isset($_POST['email']) && isset($_FILES['rc']) && isset($_FILES['dl']) && isset($_FILES['plc']) && isset($_FILES['ic'])) {

    // Validate and handle each file
    $email = trim($_POST['email']);

    // Validate files
    $files = ['rc', 'dl', 'plc', 'ic'];
    $file_paths = [];

    foreach ($files as $file_key) {
        $file = $_FILES[$file_key];
        $validation_result = validate_file($file);
        if ($validation_result !== true) {
            die($validation_result);
        }

        // Upload the file to a directory
        $upload_dir = "uploads/"; // Directory to store uploaded files
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            $file_paths[$file_key] = $file_path;
        } else {
            die("Error uploading $file_key.");
        }
    }

    // Handle optional "others" file
    $others_path = null;
    if (isset($_FILES['others']) && $_FILES['others']['error'] == 0) {
        $others = $_FILES['others'];
        $validation_result = validate_file($others);
        if ($validation_result !== true) {
            die($validation_result);
        }
        $others_path = $upload_dir . basename($others['name']);
        if (!move_uploaded_file($others['tmp_name'], $others_path)) {
            die("Error uploading others document.");
        }
    }

    // Insert document paths into the database
    $stmt = $conn->prepare("INSERT INTO documents1 (email, rc, dl, plc, ic, others) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $file_paths['rc'], $file_paths['dl'], $file_paths['plc'], $file_paths['ic'], $others_path);

    if ($stmt->execute()) {
        echo '
        <h1><strong>Documents uploaded successfully!</strong></h1>
        <a href="triveni.php"><button>View Documents</button></a>
        <br><br><br>
        <button><a href="">Generate QR</a></button>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    die("Error: Missing form fields or files.");
}

$conn->close();
?>
