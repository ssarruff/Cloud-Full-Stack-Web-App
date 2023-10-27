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
    <title>Smart City Webpage</title>
    <link rel="stylesheet" href="css/StyleSheet2.css">

</head>
<body>
    <header>
        <h1>Smart City</h1>
    </header>
            <h2>Smart Led Dashboard</h2>
            <div class="topnav">
    <a class="active" href="about-us.php">About Us</a>
    <a class="active" href="dashboard.php">Dashboard</a>
    <a class="active" href="contact-us.php">Contact Us</a>
    <a class="active" href="form.php">Form</a>
    <a class="active" href="logout.php" style="float: center;">Logout</a>
    </div>
            
            
            <iframe title="Report Section" width="1024" height="804" src="https://app.powerbi.com/view?r=eyJrIjoiOThiM2Y3OGMtZjA2ZC00ZDViLTlmNDEtNDE1Nzg3YjA5OWQ1IiwidCI6IjRiMjU5Yjk4LTM5MzEtNGMwYS05ZGEwLTcwYzRlNGU1ZWI5YSIsImMiOjJ9" frameborder="0" allowFullScreen="true"></iframe>
   
  
    <footer>
        <p>Copyright © 2023 Smart City</p>
    </footer>
</body>
</html>
