<html>
    <head>
        <style>
            /* General Styles */
            body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2c3e50, #3498db);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            color: #fff;
        }
        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width:60%;
        }
        h1 {
            font-size: 2rem;
            color: #fff;
        }
        .highlight {
            font-weight: bold;
            color: #ffeb3b;
        }
        p {
            font-size: 1.2rem;
        }
        .button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #4facfe;
            background: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .button:hover {
            background: #ffeb3b;
            color: #333;
        }
        .emoji {
            font-size: 1.5rem;
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

// Check if 'name' and 'password' are set in POST request
if (isset($_POST['name']) && isset($_POST['password'])) {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $user_email=trim($_POST['email']); // User input password

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT name, email, password FROM vdstorage WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    
    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // If passwords are hashed in the database, use password_verify()
        if ($password === $row["password"]) {
            // Passwords match, proceed to login
            $_SESSION['name']=$name;
            $_SESSION['email']=$user_email;
            header("location:board.php");
        } else {
            echo  "<div class='error-msg'>❌ Incorrect Password!</div>";
        }
    } else {
        echo "<div class='error-msg'>❌ Please provide a username and password.</div>";
    }

    // Close statement
    $stmt->close();
} else {
    echo "❌ Please provide a  valid username and password.";
}

// Close connection
$conn->close();
?>
</body>
</html>