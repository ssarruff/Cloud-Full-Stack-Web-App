<?php

// Smart City Lighting two-factor authentication for secure user login.

session_start();

// PHPMailer library inserted in the webapp file to allow email messaging.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// To add PHPMailer library inserted in the webapp file to allow email messaging.
require "PHPMailer-master/PHPMailer-master/src/Exception.php";
require "PHPMailer-master/PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/PHPMailer-master/src/SMTP.php";

if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Link to db.php page that contains the database connection.
include_once "db.php";

// To get the user id that is logging in.
$userID = $_SESSION["id"];

// To get the email from the database of the user logging in.
$stmt = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row["email"];

    // To randomly generate a code that its also stored.
    $code = mt_rand(100000, 999999);
    $_SESSION["two_factor_code"] = $code;

    // PHPMailer configuration to send email to the user logging in.
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'smartlightingproject@gmail.com'; 
    $mail->Password = 'swvjaqbpqzdulbqv'; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587; 

    // Smart City Lighting email details from the sender.
    $mail->setFrom('smartlightingproject@gmail.com', 'Smart City Authenticator');

     // Code used to set the user's email.
    $mail->addAddress($email);

    // Code used to add a predetermined subject and message.
    $subject = "Verification Code for Two-Factor Authentication";
    $message = "Your verification code: " . $code;
    $mail->Subject = $subject;
    $mail->Body = $message;

    try {
    // Sends the email to the user with implemented exceptions.
    $mail->send();
    $verificationMessage = "Verification code sent to " . $email . "<br>";
} catch (Exception $e) {
    $verificationMessage = "Failed to send the verification code to " . $email . ". Please try again.<br>";
}
} else {
    // The user could not be found message.
    echo "User not found.";
}

// To close database as part of a godd practice in case there are other databases.
$stmt->close();
$con->close();

// Code that redirects the users to a verification page.
$_SESSION["verification_message"] = $verificationMessage;
header("Location: code-verification.php");
exit();
?>
