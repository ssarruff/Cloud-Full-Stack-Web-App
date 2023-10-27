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
    <div class="topnav">
    <a class="active" href="about-us.php">About Us</a>
    <a class="active" href="dashboard.php">Dashboard</a>
    <a class="active" href="contact-us.php">Contact Us</a>
    <a class="active" href="form.php">Form</a>
    <a class="active" href="logout.php" style="float: center;">Logout</a>
    </div>
    <main>

        <form class="form-inner">
            <section id="about-us">
                <h2>Welcome to Smart City</h2>
                <h3>About Us</h3>
                <p>Our primary goal is to improve the quality of life while focusing on energy efficiency, cost reduction and environmentally friendly concept for cities.</p>
                <p>We know the importance of lighting is to create a safe, and efficient environment. Cities will become smarter and more responsive to people's necessities by replacing legacy lights with LED lights and the smart city concept overall. </p>
                <p>Light sensors, humidity sensors, temperature sensors, and energy consumption verification enable the lighting infrastructure to operate at its peak efficiency, adjusting to environmental changes in real time being a key part to sustainability.</p>
                <p>The humidity and temperature sensors integrated into the smart lighting system respond to changing weather conditions. With this, inefficiencies and potential improvements are identified.</p>
                <p>This allows us to support responsible energy management and reduce waste in cities.</p>
                <p>The Smart City concept, when implemented, will redefine the way of life and create a better future enhancing the wellbeing of the people</p>
                <p>and making a sustainable, connected, and smart world.</p>
            </section>
        </form>
    </main>
    <footer>
        <p>Copyright © 2023 Smart City</p>
    </footer>
</body>
</html>