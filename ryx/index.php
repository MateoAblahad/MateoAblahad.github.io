<?php
session_start();
include 'php/db-accounts.php';
include 'php/functions.php';
const EMAIL_REQUIRED =  'Enter your email.';
const PASSWORD_REQUIRED = 'Enter your password.';
const LOGIN_FAILED = 'Invalid email or password.';

$errors = [];
$inputs = [];

if (isset($_POST['send'])) {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = trim($email);

    if (empty($email)) {
        $errors['email'] = EMAIL_REQUIRED;
    } else {
        $inputs['email'] = $email;
    }

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = trim($password);

    if (empty($password)) {
        $errors['password'] = PASSWORD_REQUIRED;
    } else {
        $inputs['password'] = $password;
    }

    if (count($errors) === 0) {
        global $pdo;

        $query = $pdo->prepare('SELECT * FROM accounts WHERE email = :email');
        $query->bindParam(':email', $inputs['email']);
        $query->execute();

        $user = $query->fetch();

        if (!$user) {
            $errors["login"] = LOGIN_FAILED;
        } else if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['surname'] = $user['surname'];
            $_SESSION['role'] = $user['role'];
            if ($_SESSION['role'] == 1) {
                header("location: php/admin-page.php");
            } else {
                header("location: php/profile.php");
                exit();
            }
        } else {
            $errors["login"] = LOGIN_FAILED;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <title>Crypto Login</title>
    <link rel="stylesheet" href="css/startpage.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>LOG IN</h2>
            <form method="POST" action="">
                <label for="email">E-mail:</label>
                <input type="text" name="email" class="form-control" id="inputEmail" value="<?= $inputs['email'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?= $errors['email'] ?? ''  ?>
                </div>
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" id="inputPassword" value="<?= $inputs['password'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?= $errors['password'] ?? ''  ?>
                </div>
                <?php if (isset($errors['login'])): ?>
                    <div class="form-text text-danger">
                        <?= $errors['login'] ?>
                    </div>
                <?php endif; ?>
                <button type="submit" name="send">Login</button>
            </form>
            <div class="options">
                <a href="php/forgot-password.php">Forgot Password</a>
                <a href="php/forgot-email.php">Forgot Email</a>
            </div>
            <a href="php/register.php" class="create-account">Create Account</a>
        </div>
    </div>

    <div class="cryptos">
        <span class="symbol">₿</span>
        <span class="symbol">Ξ</span>
        <span class="symbol">Ⓣ</span>
        <span class="symbol">ɱ</span>
        <span class="symbol">Ξ</span>
        <span class="symbol">₿</span>
    </div>
</body>

</html>