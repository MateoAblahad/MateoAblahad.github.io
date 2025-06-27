<?php

?>

<!DOCTYPE html>
<html lang="en">
<!-- contact page-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
            href="https://fonts.googleapis.com/css2?family=Audiowide&family=Electrolize&family=Phudu:wght@300..900&family=Unbounded:wght@200..900&display=swap"
            rel="stylesheet">
    <link rel="stylesheet" href="../css/contact.css">
    <title>Contact</title>
</head>

<body>
  <header>
        <?php include '../views/header.php';
        include("functions.php");
        loginMessage(true);
        ?>
    </header>
    <div class="content-wrapper">
        <div class="info">
            <h2>Contact</h2>
            <p>Ways to contact us:</p>
            <p>E-mail: Decryptx@cryptolegend.com</p>
            <p>Phone Number: 0694203604</p>
            <p>Instagram: @decryptx.crypt</p>
        </div>

        <div class="container">
            <div class="input-question-box">
                <h2>Submit Question</h2>
                <form>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" placeholder="Enter your email" required>

                    <label for="questionfield">Your Question:</label>
                    <textarea id="questionfield" placeholder="Type your question here..." required></textarea>

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
        <footer>
            <?php include '../views/footer.php'; ?>
        </footer>
    </div>
</body>

</html>