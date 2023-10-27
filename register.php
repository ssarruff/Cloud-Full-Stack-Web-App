<?php

// Welcome to Smart City Lightning Registration PHP server and HTML code for the User Registration page.  

session_start();

// Connection for phpMyAdmin database.
$servername = "localhost"; // Hostname phpMyAdmin (xampp).
$username = "root"; // My database username.
$password = ""; // My database password.
$dbname = "ssarruff"; // My Database name.

// Required to setup connection.
$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " .mysqli_connect_error());
}

// Operates the submit in the form.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // This part is for the input values in the database.
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($con, $_POST["confirm_password"]);

    // Validation that verifies that passwords match:
    if ($password !== $confirmPassword) {
        echo "Error: Passwords do not match.";
        exit();
    }

    // Validation that verifies if the username is already in use by another user in the database.
    $verifyUsernameQuery = "SELECT * FROM users WHERE username = '$username'"; //.
    $verifyUsernameResult = mysqli_query($con, $verifyUsernameQuery);
    if (mysqli_num_rows($verifyUsernameResult) > 0) {
        echo "Error: Username already exists.";
        exit();
    }

    // This code generates a random key for the user. This was implemented as a necessity for the two way authentication form requirements based on the documentation.
    $secretKey = generateSecretKey();

    // This code is a form of security in case of a illicit breach of the database to protect users accounts from a hack.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // This code is a form of security in case of a illicit breach of the database. It is my understanding it is not completely obligatory, but its a good practice of security.
    $hashedSecretKey = password_hash($secretKey, PASSWORD_DEFAULT);

    // This part inserts the users registration credentials into the database to create and account and automatically assigns a secret key in order to receive a two way authenticator code for security purposes.
    $sql = "INSERT INTO users (username, email, password, secret_key) VALUES ('$username', '$email', '$hashed_password', '$hashedSecretKey')";
    if (mysqli_query($con, $sql)) {
        // This is a code that directs the user back to the login page, called index.php in this case, to faciliate translation for the user and have a better experience.
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " .mysqli_error($con);
    }
}

 // This generates a secret random keyGenerate a random secret key using any suitable method.
function generateSecretKey() {
    $secretKey = ""; //Random key generator.
    return $secretKey;
}

// To close connection in case there are more database connections. This specific code works without the use of it, but per reading documentation, is a good practice.
mysqli_close($con);
?> 

<!DOCTYPE html> <!-- To begin writing the HTML code -->
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- To make sure that regardless in what device the wep page is used, it would be visible and properly usable. -->
    <title>Smart City Webpage</title> <!-- Title of the webpage (Browser tab) -->
    <link rel="stylesheet" href="css/StyleSheet1.css">
</head>
<body>
    <div class="container">
        <div id="register">
            <h1><center>Smart City</center></h1> <!-- Written to orient users and admin in  what page they are at. -->
            <h2><center>Registration</center></h2> <!-- Written to orient users and admin in  what page they are at. -->
            <form action="#" method="POST"> <!-- The HTTP method used to send this form. -->
                <label for="username" id="username">Username:</label> <!-- Labels created for the purpose of letting the user or admin know the type required for login in case of confusion due to prefilled box -->
                <input type="text" id="username" name="username" placeholder="Username"> <!-- Type text to allow any use of characters -->
                <label for="email" id="email">Email:</label> 
                <input type="email" id="email" name="email" placeholder="Email"> <!-- Type email to let users know it requires an "@emil.com" or else it does not allow registration  -->
                <label for="password" id="password">Password:</label> 
                <input type="password" id="password" name="password" placeholder="Password"> <!-- Type password to enter to the web page.  -->
                <label for="confirm_password" id="confirm_password">Confirm Password:</label> 
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"> <!-- Type confirm password to validate password entered and avoid user mistakes.  -->
                <input type="hidden" id="user-redirect-url" name="user-redirect-url2" value="index.php"> <!-- Added in case the header(location: "index.php") does not send the user to the login page -->
                <input type="submit" name="submit" value="Register"> <!-- Input to trigger the registration event.  -->
            </form>
            <p>Already have an account? <a href="index.php">Login here.</a></p> <!-- Link to index.php (User login) page in case the user already has an account. -->
        </div>
    </div>
</body>
</html>
