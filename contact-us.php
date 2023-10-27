<?php

// Smart City Lighting "Contact Us" page. Created to contact administrators.

session_start();
if(!isset($_SESSION["username"])){
    header("Location: index.php");
    exit();
}
// PHPMailer library inserted in the webapp file to allow email messaging.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// To add PHPMailer library inserted in the webapp file to allow email messaging.
require "PHPMailer-master/PHPMailer-master/src/Exception.php";
require "PHPMailer-master/PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/PHPMailer-master/src/SMTP.php";

// Sends user to the index page if the variable is not set.
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Verifies the HTTP method to then get the values from POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $mail = new PHPMailer; //Creates the instance of PHPMailer library to send emails using PHP.
    $mail->isSMTP(); // To use Simple Mail Transfer Protocol. A protocol to send emails as learned in Computer Networks.
    $mail->Host = 'smtp.gmail.com'; // To utilize the Gmail server as host.
    $mail->Port = 587; // Port for secure SMTP for Gmail.
    $mail->SMTPAuth = true; // To require authentication.
    $mail->Username = ''; // Email created for the purpose of sending verification codes, two way authorization codes and receiving user messages from the "Contact_Us" page.
    $mail->Password = ''; // Secure password generated from the Smart City Lighting gmail account.

    $mail->setFrom($email, $name); // The "from" where the message is sent. Sender's email.
    $mail->addAddress(''); // Admin's email address
    $mail->Subject = 'New Message from Smart City Lighting Website'; // Is the subject of the sent email.
    $mail->Body = "Name: $name\n\nEmail: $email\n\nMessage: $message"; // It organizes the message in the email.

    if ($mail->send()) { // Conditions to confirm the success of the message sent.
        echo "Message sent successfully!"; // Message succesfully sent. I left the message to show in the page to demostrate its function.
    } else {
        echo "Failed to send the message. Please try again later."; // Message failed to send. In this case, its time to verify the code.
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart City Webpage</title>
    <link rel="stylesheet" href="css/StyleSheet2.css">
</head>
<body>
    <header>
        <h1>Smart City</h1>
    </header>
    <div class="topnav">
    <a class="active" href="about-us.php">About Us</a>
    <a class="active" href="dashboard.php">Dashboard</a>
    <a class="active" href="contact-us.php">Contact Us</a>
    <a class="active" href="form.php">Form</a>
    <a class="active" href="logout.php" style="float: center;">Logout</a>
    </div>
    <main>
        <section id="contact-us">
            <h2>Contact Us</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <br>
                <label for="message">Message:</label>
                <textarea id="message" name="message"></textarea>
                <br><br>
                <input type="submit" value="Send">
            </form>
        </section>
    </main>
    <footer>
    <p>Copyright © 2023 Smart City</p>
    </footer>
</body>
</html>
