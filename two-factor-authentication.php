<?php

// Two-factor authentication for secure user login.

/*
Security Considerations:
- Session management ensures that critical information (like the user ID and OTP) is stored securely and can only be accessed by the authenticated session.
- Database security is handled by using prepared statements to prevent SQL injection attacks.
- The system uses TLS encryption for sending emails, adding another layer of security to protect against potential attacks like MITM (Man-In-The-Middle). 
*/

/*
The use of session management ensures that:
Session Isolation: Each user’s session is isolated from others, preventing cross-session access to sensitive data.
Session Continuity: The user's session remains active throughout the authentication process, allowing the system to track and validate the OTP during verification.
Data Protection: By storing the OTP and user information in session variables, you ensure that the data is only available during the user's authenticated session, enhancing security.
*/

//Function is called at the beginning to initiate the session. This is essential to track the user's login status and store the 2FA verification code in session variables.
session_start(); 

// PHPMailer library inserted in the webapp file to allow email messaging. I used the PHPMailer library to send emails securely. This choice ensures a professional and reliable method for delivering the OTP to the user's email.
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// To add PHPMailer library inserted in the webapp file to allow email messaging. The PHPMailer configuration allows for secure email communication using SMTP with TLS encryption, making it difficult for malicious actors to intercept messages.
require "PHPMailer-master/PHPMailer-master/src/Exception.php";
require "PHPMailer-master/PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/PHPMailer-master/src/SMTP.php";

// The system first checks if the user is logged in by verifying the session variables. If the user is not logged in, they are redirected to the login page. 
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Link to db.php page that contains the database connection. 
include_once "db.php";

// To get the user id that is logging in. 
$userID = $_SESSION["id"];

// To get the email from the database of the user logging in. 
// Using the logged-in user's ID, a database query (SELECT email FROM users WHERE id = ?) retrieves the user's email address from the database.
$stmt = $con->prepare("SELECT email FROM users WHERE id = ?"); //Database security is handled by using prepared statements to prevent SQL injection attacks.
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row["email"];

    // To randomly generate a code that its also stored.
    // A random six-digit code (OTP) is generated using mt_rand(100000, 999999). This ensures the code is difficult to predict, adding another layer of security.
    // The generated code is stored in the session ($_SESSION["two_factor_code"]) for later verification.
    $code = mt_rand(100000, 999999);
    $_SESSION["two_factor_code"] = $code;

    // PHPMailer configuration to send email to the user logging in. PHPMailer is configured to send the OTP to the user's registered email address.
    /*
    PHPMailer library will use TLS (Transport Layer Security) to encrypt the email communication between your web application and the email server (smtp.gmail.com). TLS ensures that the data transmitted, including the OTP sent to the user, is encrypted, making it secure from potential interception by malicious actors during transmission.
    Using TLS prevents attacks like Man-In-The-Middle (MITM), where an attacker could potentially intercept and read unencrypted data. By enabling TLS, you're adding an important layer of security to protect the sensitive OTP during the email process.
    */
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = ''; 
    $mail->Password = ''; 
    $mail->SMTPSecure = 'tls'; // The system uses TLS encryption for sending emails, adding another layer of security to protect against potential attacks like MITM (Man-In-The-Middle). 
    $mail->Port = 587; // Port 587 is the default port for sending emails securely using SMTP (Simple Mail Transfer Protocol) with TLS (Transport Layer Security) encryption. It is widely used for submitting email messages from a client (like your web app) to an email server, which then forwards the message to the recipient's server.

    // Smart City Lighting email details from the sender.
    $mail->setFrom('', '');

     // Code used to set the user's email.
    $mail->addAddress($email);

    // Code used to add a predetermined subject and message. The subject and message body include a personalized message with the OTP. This step ensures that the user is prompted to enter the correct code on the next page.
    $subject = "Verification Code for Two-Factor Authentication";
    $message = "Your verification code: " . $code;
    $mail->Subject = $subject;
    $mail->Body = $message;

    try {
    // Sends the email to the user with implemented exceptions. Exception handling is implemented using PHPMailer’s built-in error handling. This ensures that if the email fails to send, the system catches the error and informs the user without breaking the authentication flow.
    $mail->send();
    $verificationMessage = "Verification code sent to " . $email . "<br>";
} catch (Exception $e) {
    $verificationMessage = "Failed to send the verification code to " . $email . ". Please try again.<br>";
}
} else {
    // The user could not be found message.
    echo "User not found.";
}

// To close database as part of a good practice in case there are other databases.
$stmt->close();
$con->close();

// Code that redirects the users to a verification page. After the email is sent, the user is redirected to a separate verification page (code-verification.php) where they input the OTP to complete the login process.
$_SESSION["verification_message"] = $verificationMessage;
header("Location: code-verification.php");
exit();
?>
