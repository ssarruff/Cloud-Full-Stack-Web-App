<?php

// Smart City Lighting two-factor authentication for secure user login.

session_start();
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"]) || !isset($_SESSION["two_factor_code"])) {
    header("Location: index.php");
    exit();
}

// Check if the token has expired
if (time() > $_SESSION["two_factor_expires"]) {
    $message = "The verification code has expired. Please try again.";
    unset($_SESSION["two_factor_code"]);
    unset($_SESSION["two_factor_expires"]);
    // Optionally, redirect them back to generate a new code
    header("Location: request-new-code.php");
    exit();
}

if (isset($_POST["submit"])) {
    $userCode = $_POST["code"];

    if ($userCode == $_SESSION["two_factor_code"]) {
        // Verification successful
        unset($_SESSION["two_factor_code"]); // Clear the code from the session
        unset($_SESSION["two_factor_expires"]); // Clear expiration
        header("Location: about-us.php");
        exit();
    } else {
        // Verification failed
        $message = "Invalid verification code!";
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
        <div id="login">
            <h1><center>Smart City</center></h1>
            <h2><center>Two-Factor Authentication</center></h2>
            <?php if (isset($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form name="frmVerify" action="" method="POST">
                <label for="code">Verification Code:</label>
                <input type="text" id="code" name="code" placeholder="Verification Code" required>
                <input type="submit" name="submit" value="Verify">
            </form>
        </div>
    </div>
</body>
</html>
