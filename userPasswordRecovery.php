<?php 

// "Forgot password" logic for users.

session_start();
require "db.php"; // Link to db.php page that contains the database connection.

// PHPMailer library inserted in the webapp file to allow email messaging.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// To add PHPMailer library inserted in the webapp file to allow email messaging.
require "PHPMailer-master/PHPMailer-master/src/Exception.php";
require "PHPMailer-master/PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/PHPMailer-master/src/SMTP.php";

$name = ""; // Used to initialize the variable $name empty.
$email = ""; // Used to initialize the variable $email empty.
$errors = array(); // Used to initialize the variable $errors empty to later add an error message.

// When the user clicks the verification code submit button.
    if(isset($_POST['check'])){
        $_SESSION['info'] = "";
        $onetimepass_code = mysqli_real_escape_string($con, $_POST['otp']);
        $verify_code = "SELECT * FROM users WHERE code = $onetimepass_code";
        $code_result = mysqli_query($con, $verify_code);
        if(mysqli_num_rows($code_result) > 0){
            $fetch_data = mysqli_fetch_assoc($code_result);
            $fetch_code = $fetch_data['code'];
            $email = $fetch_data['email'];
            $code = 0;
            $status = 'verified';
            $update_onetimepass = "UPDATE users SET code = $code, status = '$status' WHERE code = $fetch_code";
            $update_result = mysqli_query($con, $update_onetimepass);
            if($update_result){
                $_SESSION['username'] = $name;
                $_SESSION['email'] = $email;
                header('location: index.php');
                exit();
            }else{
                $errors['onetimepass-error'] = "Failed while updating code!";
            }
        }else{
            $errors['onetimepass-error'] = "You've entered the wrong code!";
        }
    }

// Transition: When the user clicks the Continue button in the "Forgot password" page.
    if(isset($_POST['check-email'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $verify_email = "SELECT * FROM users WHERE email='$email'";
        $run_sql = mysqli_query($con, $verify_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111); // Built-in PHP function for a random number generator between 999999 & 111111.
            $insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                // PHPMailer configuration necessary for the mailing system to work.
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // SMTP service provider. In our case we are using Gmail.com.
                $mail->SMTPAuth = true;
                $mail->Username = ''; // Email created for the purpose of sending verification codes, two way authorization codes and receiving user messages from the "Contact_Us" page.
                $mail->Password = ''; // Secure password generated from the Smart City Lighting gmail account.
                $mail->SMTPSecure = 'tls'; //Use for server config. 
                $mail->Port = 587; //This is the port number required for message purposes. Needs to be open to avoid errors.
    
                // Smart City Lighting email details so that the system recognizes a sender.
                $mail->setFrom('', '');
    
                // Code used to place or put the user's email.
                $mail->addAddress($email);
    
                // Code used to add a predetermined subject and message to make sense of what the user is receiving.
                $mail->Subject = 'Password Reset Code';
                $mail->Body = "Your password reset code is $code";
    
                try {
                    // Sends the email to the user with implemented exceptions.
                    $mail->send();
                    $info = "We've sent a password reset code to $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                } catch (Exception $e) {
                    $errors['onetimepass-error'] = "Failed while sending code!";
                }
            }else{
                $errors['database-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
        }
    }
     
// Transition: When the user clicks on the check reset button.
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $onetimepass_code = mysqli_real_escape_string($con, $_POST['otp']);
        $verify_code = "SELECT * FROM users WHERE code = $onetimepass_code";
        $code_result = mysqli_query($con, $verify_code);
        if(mysqli_num_rows($code_result) > 0){
            $fetch_data = mysqli_fetch_assoc($code_result);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password:";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['onetimepass-error'] = "You've entered the wrong code!";
        }
    }

// When the user clicks the Change password button to trigger the change or modification in the database.
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['email']; 
            $encrypt_pass = password_hash($password, PASSWORD_BCRYPT);
            $update_pass = "UPDATE users SET code = $code, password = '$encrypt_pass' WHERE email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                $info = "Your password has been changed!";
                $_SESSION['info'] = $info;
                header('Location: password-changed.php');
            }else{
                $errors['database-error'] = "Failed to change your password!";
            }
        }
    }
?>
