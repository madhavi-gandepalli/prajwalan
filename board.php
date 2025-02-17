


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - V-Docs</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="board.css">
</head>
<body>


<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "hackthon";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'name' and 'password' are set in POST request
if (isset($_POST['name']) && isset($_POST['password'])) {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT name, email, password FROM vdstorage WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (!password_verify($password, $row['password'])) {
            die("Invalid credentials.");
        }

        // ✅ Store user details in SESSION
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        die("User not found.");
    }

    $stmt->close();
}

$conn->close();
?>


<div class="container">
    <h2>Welcome to Your Dashboard</h2>

    <div class="section profile-section">
      <img src="user-avatar.png" alt="User Avatar">

<div class="profile-info">
    <p><strong>Name:</strong> </p> <!-- <span class="highlight"><?php echo htmlspecialchars($_SESSION['name']); ?></span> -->
    <p><strong>Email:</strong></p>  <!-- <?php echo htmlspecialchars($_SESSION['email']); ?> -->
</div>

      <a href="profile.html" class="button2">Edit Profile</a>
    </div>

    <div class="section vehicle-section">
      <h3><i class="fas fa-car"></i> Vehicle Details</h3>
      <p><strong>Vehicle:</strong> <span id="vehicleName">Honda City</span></p>
      <p><strong>Reg. Number:</strong> <span id="vehicleRegNo">AP 12 XY 3456</span></p>
      <a href="vehicle.php" class="button1">Edit Vehicle</a>
      <a href="qr-scanner.html" class="button"><i class="fas fa-qrcode"></i> Scan QR Code</a>
    </div>

    <div class="section documents-section">
      <h3><i class="fas fa-folder"></i> Documents</h3>
      <ul id="documentList"></ul>
     <!-- <p id="emptyMessage" class="empty-message">No documents uploaded yet.</p> -->
      <button onclick="window.location.href='upload.php'" class="button3">
        <i class="fas fa-upload"></i> Upload Document
      </button>
      <a href="triveni.php" class="button"><i class="fas fa-qrcode"></i>uploaded documents</a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      let documents = [];
      let documentList = document.getElementById("documentList");
      let emptyMessage = document.getElementById("emptyMessage");

      function updateDocumentUI() {
        documentList.innerHTML = "";

        if (documents.length === 0) {
          emptyMessage.style.display = "block";
        } else {
          emptyMessage.style.display = "none";
          documents.forEach((doc, index) => {
            let li = document.createElement("li");
            li.innerHTML = `<i class="fas fa-file-pdf"></i> ${doc} 
                            <button onclick="deleteDocument(${index})">Delete</button>`;
            documentList.appendChild(li);
          });
        }
      }

      window.uploadDocument = function () {
        let newDoc = prompt("Enter Document Name:");
        if (newDoc) {
          documents.push(newDoc + ".pdf");
          updateDocumentUI();
        }
      };

      window.deleteDocument = function (index) {
        documents.splice(index, 1);
        updateDocumentUI();
      };

      window.editVehicle = function () {
        let newVehicle = prompt("Enter Vehicle Name:", document.getElementById("vehicleName").innerText);
        let newRegNo = prompt("Enter Registration Number:", document.getElementById("vehicleRegNo").innerText);
        if (newVehicle && newRegNo) {
          document.getElementById("vehicleName").innerText = newVehicle;
          document.getElementById("vehicleRegNo").innerText = newRegNo;
        }
      };

      updateDocumentUI();
    });
</script>
</body>
</html>
