<?php

?>
<!-- home page-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to DecryptX</title>
    <link rel="stylesheet" href="../css/home-page.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <header>
        <?php include '../views/header.php';
        include("functions.php");
        loginMessage(true);
        ?>
    </header>
    <div class="content">
        <h1 class="welcome-text">Welcome to DECRYPTX</h1>
        <p class="description">
            We are thrilled to have you here! At DECRYPTX, our mission is to guide you through the exciting world of cryptocurrency. 
            Whether you're a beginner or an experienced trader, our expert guides will help you navigate the crypto space with confidence.
            <br><br>Good luck, and may your investments thrive!
        </p>
    </div>
    <footer>
    <?php include '../views/footer.php'; ?> 
    </footer>
</body>

</html>