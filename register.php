<?php
session_start(); 
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("location: home.html");
    exit;
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful. Redirecting to login...";
        header("refresh:2;url=index.php"); 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <script type="module" src="https://unpkg.com/@splinetool/viewer@1.5.4/build/spline-viewer.js"></script>
        <spline-viewer url="https://prod.spline.design/W-uRgErv3LPpncFI/scene.splinecode"></spline-viewer>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="index.php">Login here</a>.</p>
    </div>
</body>
</html>
