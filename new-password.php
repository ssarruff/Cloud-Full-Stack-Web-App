<?php 
require_once "userPasswordRecovery.php";

$email = $_SESSION['email'];
if($email == false){
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a New Password</title>
    <link rel="stylesheet" href="css/StyleSheet1.css">
</head>
<body>
    <div class="container">
        <form action="new-password.php" method="POST" autocomplete="off">
        <center><h2>Create New Password</h2></center>
        <?php
        if(count($errors) > 0){
        ?>
        <div class="alert alert-danger text-center">
        <?php
        foreach($errors as $showerror){
            echo $showerror;
            }
        ?>
        </div>
        <?php
        }
        ?>
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Create new password" required>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="cpassword" placeholder="Confirm new password" required>
        </div>
        <div class="form-group">
            <input class="form-control button" type="submit" name="change-password" value="Confirm">
        </div>
        </form>
    </div>
</body>
</html>