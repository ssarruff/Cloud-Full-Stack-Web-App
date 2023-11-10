<?php

// Smart City Lighting "About Us" page. Created to inform about the web page and developers.

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
    <div class="topnav" style="background-color: ">
 
    <a class="active" href="form.php">Form</a>
    <a class="active" href="logout.php" style="float: center;">Logout</a>
    </div>
    <main>

        <form class="form-inner">
            <section id="about-us">
                <h2>Welcome to Smart City</h2>
                <h3>User survey</h3>
                <iframe src="" width="640" height="1218" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
              
            </section>
        </form>
    </main>
    <footer>
        <p>Copyright © 2023 Smart City</p>
    </footer>
</body>
</html>
