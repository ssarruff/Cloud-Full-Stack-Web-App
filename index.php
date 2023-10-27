<?php

// Welcome to Smart City Lightning Registration PHP server and HTML code for the User login page. 

session_start();

// To include the autoloader file from Composer. Composer is a tool for the installation of libraries that are outside of the project.
require_once 'vendor/autoload.php'; 

$message = ""; // Used to initialize the variable $message empty to later add an error message.

if (isset($_POST["submit"])) {
    include_once "db.php"; //The page db.php contains the database connection code.
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $stmt = $con->prepare("SELECT id, username, password, secret_key FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            if (!empty($row["secret_key"])) {
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                header("Location: two-factor-authentication.php?username=" .urlencode($username));
                exit();
            } else {
                //This code generates a random key for the user. This was implemented as a necessity for the two way authentication form requirements based on the documentation:
                $secretKey = generateSecretKey();
                
                // Store the secret key in the user's row in the database
                $stmt = $con->prepare("UPDATE users SET secret_key = ? WHERE id = ?");
                $stmt->bind_param("si", $secretKey, $row["id"]);
                $stmt->execute();
                
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                header("Location: about-us.php");
                exit();
            }
        } else {
            $message = "Invalid username or password!";
        }
    } else {
        $message = "Invalid username or password!";
    }
}

// Generates random bytes for a secret key to be used for authentication purposes.
function generateSecretKey() {
    $secretKey = bin2hex(random_bytes(16)); // Built-in PHP function that generates a 32 character random secret key.
    return $secretKey;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart City Webpage</title>
    <link rel="stylesheet" href="css/StyleSheet1.css">
</head>
<body>

    <div class="container">
        <div id="login">
            <h1><center>Smart City</center></h1>
            <h2><center>User login</center></h2>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form name="frmUser" action="" method="POST"> <!-- The name assigned to the form, the action to specify the form where the data is sent and the HTTP method used to send this form. -->
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password">
                <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()"> Show Password<br><br>
                <div><a href="forgot-password.php">Forgot password?</a></div><br>
                <input type="submit" name="submit" value="Login">
            </form>
            <p>Don't have an account? <a href="register.php">Sign up here.</a></p>
            <p>Are you an administrator? Log in <a href="adminloginpage.php">here.</a></p>
        </div>
    </div>
    
    <!-- Javascript code -->
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>

</body>
</html>
