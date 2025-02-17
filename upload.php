<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Vehicle Documents</title>
    <link rel="stylesheet" href="upload.css"> <!-- Link to external CSS -->
    <style>
        body {
    background: linear-gradient(to right, #2c3e50, #3498db);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.size{
    font-size:20px;
    weight: 40px;;
}
.input{
margin:20px;
box-sizing:border-box;
}
</style>
</head>
<body>

    <div class="container">
        <h2>Upload Vehicle Documents</h2>

        <form id="uploadForm" action="doc.php" method="POST" enctype="multipart/form-data">
            <label for="email" class="size" class="input" size="30">Email:</label>
            <input type="email" placeholder="Email" id="email" name="email" required>

            <label for="rc" class="size">RC (Registration Certificate):</label>
            <input type="file" name="rc" id="rc" accept=".pdf,.jpg,.png,.jpeg" required>

            <label for="license" class="size">Driving License:</label>
            <input type="file" name="dl" id="license" accept=".pdf,.jpg,.png,.jpeg" required>

            <label for="pollution" class="size">Pollution Certificate:</label>
            <input type="file" name="plc" id="pollution" accept=".pdf,.jpg,.png,.jpeg" required>

            <label for="insurance" class="size">Insurance Certificate:</label>
            <input type="file" name="ic" id="insurance" accept=".pdf,.jpg,.png,.jpeg" required>

            <label for="other" class="size">Other Documents (Optional):</label>
            <input type="file" name="others" id="other" accept=".pdf,.jpg,.png,.jpeg">

            <!-- Submit button for uploading -->
            <button type="submit">Upload Documents</button>
        </form>
    </div>



    <!-- Generate QR Code Button -->
   
</body>
</html>