<?php
// Database connection details
$host = "localhost"; // hostname
$username = "id20780885_root"; // MySQL username
$password = "Capstone2@"; // MySQL password
$dbname = "id20780885_smartcity"; // database name

// Establishing database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Getting form input values
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

    // Check if the "Confirm Password" matches the "Password"
    if ($password !== $confirmPassword) {
        echo "Error: Passwords do not match.";
        exit();
    }

    // Check if the username already exists in the database
    $checkUsernameQuery = "SELECT * FROM admins WHERE username = '$username'";
    $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);
    if (mysqli_num_rows($checkUsernameResult) > 0) {
        echo "Error: Username already exists.";
        exit();
    }

    // Hashing the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserting new user into the database
    $sql = "INSERT INTO admins (username, email, password, code, status) VALUES ('$username', '$email', '$hashed_password', '', '')";
    if (mysqli_query($conn, $sql)) {
        // Redirecting to login page
        header("Location: adminloginpage.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Closing database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Lighting Webpage</title>
    <link rel="stylesheet" href="css/StyleSheet1.css">
</head>
<body>
    <div class="container">
        <div id="register">
            <h1><center>Smart Lighting</center></h1>
            <h2><center>Admin Private Registration</center></h2>
            <form action="#" method="POST">
                <label for="username" id="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="email" id="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password" id="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password" id="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required autocomplete="current-password">
                <input type="hidden" id="user-redirect-url" name="user-redirect-url2" value="index.php">
                <input type="submit" name="submit" value="Register">
            </form>
            <p>Already have an account? <a href="index.php">Login here.</a></p>
        </div>
    </div>
</body>
</html>
