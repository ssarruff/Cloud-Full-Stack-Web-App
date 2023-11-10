<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart City Administrator</title>
    <link rel="stylesheet" href="css/StyleSheet3.css">
</head>
<body>
    <h1>Smart City Administrator</h1>
    <br>
    
      <iframe title="Report Section" width="1024" height="804" src="" frameborder="0" allowFullScreen="true"></iframe>
    
     <br>
       <a class="button" href="">Admin Access</a>
       <br>
        <a class="button" href="logout.php">Logout</a>
        <br>
    
</body>
</html>

