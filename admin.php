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
    
      <iframe title="Report Section" width="1024" height="804" src="https://app.powerbi.com/view?r=eyJrIjoiOThiM2Y3OGMtZjA2ZC00ZDViLTlmNDEtNDE1Nzg3YjA5OWQ1IiwidCI6IjRiMjU5Yjk4LTM5MzEtNGMwYS05ZGEwLTcwYzRlNGU1ZWI5YSIsImMiOjJ9" frameborder="0" allowFullScreen="true"></iframe>
    
     <br>
       <a class="button" href="https://app.powerbi.com/singleSignOn?pbi_source=websignin_home_hero&ru=https%3A%2F%2Fapp.powerbi.com%2F%3Fpbi_source%3Dwebsignin_home_hero%26noSignUpCheck%3D1">Admin Access</a>
       <br>
        <a class="button" href="logout.php">Logout</a>
        <br>
    
</body>
</html>

