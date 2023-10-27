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
    <title>Code Verification</title>
    <link rel="stylesheet" href="css/StyleSheet1.css">
</head>
<body>
    <div class="container">
        <form action="reset-code.php" method="POST" autocomplete="off">
        <center><h2>Code Verification</h2></center>
        <?php 
        if(isset($_SESSION['info'])){
        ?>
        <div class="alert alert-success text-center" style="padding: 0.4rem 0.4rem">
        <?php echo $_SESSION['info']; ?>
        </div>
        <?php
        }
        ?>
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
        <br>
        <div class="form-group">
            <input class="form-control" type="text" name="otp" placeholder="Enter code" required>
        </div>
        <br>
        <div class="form-group">
            <input class="form-control button" type="submit" name="check-reset-otp" value="Submit">
        </div>
        </form>     
    </div>
</body>
</html>