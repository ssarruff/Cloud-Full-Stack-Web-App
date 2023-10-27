<?php
require_once "userPasswordRecovery.php";

if($_SESSION['info'] == false){
    header('Location: index.php');  
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/StyleSheet1.css">
</head>
<body>
    <div class="container">
    <?php 
    if(isset($_SESSION['info'])){
    ?>
    <div class="alert alert-success text-center">
    <?php echo $_SESSION['info']; ?>
    </div>
    <?php
    }
    ?>
    <form action="index.php" method="POST">
        <div class="form-group"><br>
            <input class="form-control button" type="submit" name="login-now" value="Login Now">
        </div>
    </form>
    </div>
</body>
</html>