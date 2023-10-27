<?php
session_start();
$message = "";

if (isset($_POST["submit"])) {
    include_once "db.php";
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $con->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            header("Location: admin.php");
            exit();
        } else {
            $message = "Invalid username or password!";
        }
    } else {
        $message = "Invalid username or password!";
    }
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
    <div id="admin-login">
        <h1><center>Smart City</center></h1>
        <h2><center>Administrator login</center></h2>
        <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
        <label for="username">Admin username:</label>
        <input type="text" id="username" name="username" placeholder="Admin username">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password">
        <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()"> Show Password<br><br>
        <div><a href="adminForgotPassword.php">Forgot password?</a></div><br>
        <input type="submit" name="submit" value="Login">
        </form>
        <p>Are you a user? <a href="index.php">Login here.</a></p>
    </div>

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
