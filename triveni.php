<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded Documents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        .file-container {
            margin-top: 20px;
            text-align: left;
        }
        .file-container p {
            margin: 10px 0;
        }
        .file-container img {
            width: 200px;
            margin: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>View Uploaded Documents</h2>

    <div class="file-container">
        <?php
        session_start();
        $conn = new mysqli("localhost", "root", "", "hackthon");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Assuming email is stored in session or predefined
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : 'madhavigandepalli23@gmail.com'; // Use session email or predefined one

        // Fetch documents for the predefined or session email
        $stmt = $conn->prepare("SELECT rc, dl, plc, ic, others FROM documents1 WHERE email = ? ORDER BY uploaded_at DESC LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "<h3>Uploaded Documents for $email</h3>";

            // Function to display the file
            function displayFile($filePath, $label) {
                if (!empty($filePath)) {
                    // Check if the file is an image
                    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                    echo "<p><strong>$label:</strong></p>";
                    if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
                        // Display image
                        echo "<img src='$filePath' alt='$label'><br>";
                    } else {
                        // Provide download link for non-image files
                        echo "<a href='$filePath' download='$label'>Download $label</a><br>";
                    }
                } else {
                    echo "<p><strong>$label:</strong> No file uploaded.</p>";
                }
            }

            // Display the documents using file paths
            displayFile($row["rc"], "RC (Registration Certificate)");
            displayFile($row["dl"], "Driving License");
            displayFile($row["plc"], "Pollution Certificate");
            displayFile($row["ic"], "Insurance Certificate");
            displayFile($row["others"], "Other Documents");

        } else {
            echo "<p>No documents found for this email.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</div>

</body>
</html>
