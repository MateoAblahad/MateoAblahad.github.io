<?php
include "db-accounts.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/footer.css">
    <title>Profile</title>
</head>
<body>
    <div class="profile">
   <header>
        <?php include '../views/header.php';
        include("functions.php");
        loginMessage(true);
        ?>
    </header>

   <dif class="change-login">
   <a href="forgot-email.php" >change email</a>
   <a href="forgot-password.php">change password</a>
   </dif>

     <footer>
    <?php include '../views/footer.php'; ?> 
    </footer>
    </div>
</body>
</html>