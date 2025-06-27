<?php
// Verbind met de database
include 'db-accounts.php';

// Definieer constante foutmeldingen
const EMAIL_REQUIRED = 'Enter your email.';
const PASSWORD_REQUIRED = 'Enter your password.';
const NAME_REQUIRED = 'Enter your name.';
const SURNAME_REQUIRED = 'Enter your surname.';
const USER_EXIST_ERROR = "You already have an account with this email. Please log in instead.";

// Arrays om fouten en ingevulde waarden op te slaan
$errors = [];
$inputs = [];

// Controleer of formulier verzonden is
if (isset($_POST['send'])) {

    // -------------------------
    // Valideer E-mail
    // -------------------------
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);

    if (empty($email)) {
        $errors['email'] = EMAIL_REQUIRED;
    } else {
        $inputs['email'] = $email;
    }

    // -------------------------
    // Valideer Naam
    // -------------------------
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $name = trim($name);

    if (empty($name)) {
        $errors['name'] = NAME_REQUIRED;
    } else {
        $inputs['name'] = $name;
    }

    // -------------------------
    // Valideer Achternaam
    // -------------------------
    $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_SPECIAL_CHARS);
    $surname = trim($surname);

    if (empty($surname)) {
        $errors['surname'] = SURNAME_REQUIRED;
    } else {
        $inputs['surname'] = $surname;
    }

    // -------------------------
    // Valideer Wachtwoord
    // -------------------------
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = trim($password);

    if (empty($password)) {
        $errors['password'] = PASSWORD_REQUIRED;
    } else {
        $inputs['password'] = $password;
    }

    // -------------------------
    // Als geen fouten, registreer gebruiker
    // -------------------------
    if (count($errors) === 0) {
        global $pdo;

        // Controleer of e-mailadres al bestaat
        $checkQuery = $pdo->prepare('SELECT * FROM accounts WHERE email = :email');
        $checkQuery->bindParam(':email', $inputs['email']);
        $checkQuery->execute();

        if ($checkQuery->fetch()) {
            // Gebruiker bestaat al
            $errors["user"] = USER_EXIST_ERROR;
        } else {
            // Maak nieuwe account aan
            $query = $pdo->prepare('INSERT INTO accounts (email, name, surname, password) VALUES(:email, :name, :surname, :password)');

            // Hash wachtwoord voor veilige opslag
            $hashedPassword = password_hash($inputs['password'], PASSWORD_DEFAULT);

            // Koppel parameters aan query
            $query->bindParam(':email', $inputs['email']);
            $query->bindParam(':name', $inputs['name']);
            $query->bindParam(':surname', $inputs['surname']);
            $query->bindParam(':password', $hashedPassword);

            // Voer query uit
            $query->execute();

            // Redirect gebruiker naar loginpagina na succesvolle registratie
            header('Location: ../index.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Register New Account</title>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h2>Register Account</h2>
            <br>

            <!-- Registratieformulier -->
            <form method="POST" action="">
                <!-- E-mailadres -->
                <label for="email">E-mail:</label>
                <input type="text" name="email" class="form-control" id="inputEmail" value="<?= $inputs['email'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?= $errors['email'] ?? '' ?>
                </div>

                <!-- Voornaam -->
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" id="inputName" value="<?= $inputs['name'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?= $errors['name'] ?? '' ?>
                </div>

                <!-- Achternaam -->
                <label for="surname">Surname:</label>
                <input type="text" name="surname" class="form-control" id="inputSurname" value="<?= $inputs['surname'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?= $errors['surname'] ?? '' ?>
                </div>

                <!-- Wachtwoord -->
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" id="inputPassword" value="<?= $inputs['password'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?= $errors['password'] ?? '' ?>
                </div>

                <!-- Foutmelding als gebruiker al bestaat -->
                <?php if (isset($errors['user'])): ?>
                    <div class="form-text text-danger">
                        <?= $errors['user'] ?>
                    </div>
                <?php endif; ?>

                <br>
                <!-- Verstuurknop -->
                <button type="submit" name="send">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
