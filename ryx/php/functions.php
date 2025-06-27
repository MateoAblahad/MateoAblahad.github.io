<?php
//function for get user
function getUser()
{
    global $pdo;

    if (isset($_SESSION["login"])) {
        $checkQuery = $pdo->prepare("SELECT * FROM accounts WHERE email = :email");
        $checkQuery->bindParam(":email", $_SESSION["email"]);
        $checkQuery->execute();
        $user = $checkQuery->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
//function for login message
function loginMessage($loginMessage) {
    global $user;
    if ($loginMessage === true) {
        echo '<div style="color:rgb(72, 255, 0); text-align: left; font-weight: bold;">Welcome ' . 
             htmlspecialchars($_SESSION['name']) . ' ' . 
             htmlspecialchars($_SESSION['surname']) . 
             '</div>';
    }
}



