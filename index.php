<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Redirect to home.html on successful login
            header("Location: home.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username. Redirecting to registration...";
        header("refresh:2;url=register.php"); // Redirect after 2 seconds
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
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.5.4/build/spline-viewer.js"></script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <spline-viewer url="https://prod.spline.design/W-uRgErv3LPpncFI/scene.splinecode"></spline-viewer>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
