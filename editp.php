//personal details html/
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personal Details</title>
<style>
    /*personal.css/
/* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  /* Basic Styles */
  body {
    font-family: 'Arial', sans-serif;
    background-color: #23486a; /* Deep Blue Background */
    color: #efb036; /* Golden Yellow for text contrast */
  }
  
  header {
    background-color: #3b6790; /* Muted Blue Header */
    padding: 10px 20px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .menu-bar {
    display: flex;
    gap: 20px;
    visibility: hidden; /* Disable Menu Bar */
  }
  
  .menu-bar a {
    color: #efb036; /* Golden Yellow Links */
    text-decoration: none;
    padding: 10px;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }
  
  .menu-bar a:hover {
    background-color: #4c7b8b; /* Teal Blue Hover Effect */
    border-radius: 5px;
  }
  
  /* Content Section */
  .content {
    margin-top: 80px; /* Space for the fixed header */
    padding: 20px;
  }
  
  h1 {
    text-align: center;
    font-size: 36px;
    color: #efb036; /* Golden Yellow Heading */
    margin-bottom: 20px;
  }
  
  .form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
    background-color: #4c7b8b; /* Teal Blue Form Background */
    border-radius: 8px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    background: linear-gradient(135deg, #4c7b8b, #3b6790);
  }
  
  .form-container label {
    font-size: 18px;
    color: #efb036; /* Golden Yellow Labels */
    margin-bottom: 10px;
    display: block;
  }
  
  .form-container input, .form-container select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    font-size: 16px;
    border: 1px solid #efb036;
    border-radius: 5px;
    background-color: #23486a;
    color: white;
    transition: all 0.3s ease;
  }
  
  .form-container input:focus, .form-container select:focus {
    border-color: #efb036;
    box-shadow: 0 0 5px rgba(239, 176, 54, 0.5);
  }
  
  .form-container input[readonly] {
    background-color: #3b6790;
    cursor: not-allowed;
  }
  
  .form-container button {
    background-color: #efb036; /* Golden Yellow Button */
    color: #23486a;
    padding: 12px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
  }
  
  .form-container button:hover {
    background-color: #d89c2e; /* Darker Golden Yellow */
  }
  
  /* Responsive Styles */
  @media (max-width: 768px) {
    .form-container {
      padding: 20px;
    }
  
    h1 {
      font-size: 28px;
    }
  }
</style> <!-- Linking external CSS file -->
</head>
<body>

  <header>
    <div class="menu-bar">
      <!-- Menu items here (but they are hidden now) -->
    </div>
  </header>

  <div class="content">
    <h1>Personal Details</h1>
    <div class="form-container">
      <form>
        <!-- First Name -->
        <label for="first-name">First Name</label>
        <input type="text" id="first-name" name="first-name" required>

        <!-- Last Name -->
        <label for="last-name">Last Name</label>
        <input type="text" id="last-name" name="last-name" required>

        <!-- Gender -->
        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>

        <!-- Date of Birth -->
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" required>

        <!-- Email (Read-only) -->
        <label for="email">Email</label>
        <input type="email" id="email" name="email"  required>

        <!-- Phone Number -->
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" required>

        <!-- Submit Button -->
        <button type="submit">Save Changes</button>
      </form>
    </div>
  </div>

</body>
</html>