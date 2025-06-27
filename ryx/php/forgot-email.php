<?php
// Verbind met de database
include 'db-accounts.php';

// Definieer constanten voor fout- en succesberichten
const PASSWORD_REQUIRED = 'Enter your password.';
const NEW_EMAIL_REQUIRED = 'Enter your new email.';
const PASSWORD_INCORRECT = 'Password is incorrect.';
const EMAIL_UPDATED = 'Email has been updated successfully.';

// Arrays voor foutmeldingen, succesmeldingen en hergebruik van invoer
$errors = [];
$success = [];
$inputs = [];

// Als het formulier verzonden is
if(isset($_POST['send'])) {
    // Haal het ingevoerde wachtwoord op en verwijder spaties
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = trim($password);

    // Controleer of het wachtwoord is ingevuld
    if(empty($password)) {
        $errors['password'] = PASSWORD_REQUIRED;
    }

    // Haal het nieuwe e-mailadres op en verwijder spaties
    $newEmail = filter_input(INPUT_POST, 'new_email', FILTER_SANITIZE_SPECIAL_CHARS);
    $newEmail = trim($newEmail);

    // Controleer of het e-mailadres is ingevuld
    if(empty($newEmail)) {
        $errors['email'] = NEW_EMAIL_REQUIRED;
    } else {
        $inputs['new_email'] = $newEmail; // Bewaar de waarde voor hergebruik in het formulier
    }

    // Als er geen validatiefouten zijn
    if(count($errors) === 0) {
        global $pdo;

        // Zoek gebruiker op basis van wachtwoord (LET OP: dit werkt niet correct zoals hieronder beschreven)
        $query = $pdo->prepare('SELECT * FROM accounts WHERE password = :password');

        // Hier wordt een nieuw wachtwoord gehasht (maar dit moet je juist vergelijken met opgeslagen hash!)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashedPassword);
        $query->execute();

        // Als een account wordt gevonden, voer dan update uit (maar dit werkt NIET correct)
        if($query->fetch()) {
            // Update het e-mailadres van de gebruiker met het overeenkomende wachtwoord
            $updateQuery = $pdo->prepare('UPDATE accounts SET email = :email WHERE password = :password');
            $updateQuery->bindParam(':email', $newEmail);
            $updateQuery->bindParam(':password', $hashedPassword);

            if($updateQuery->execute()) {
                // Toon succesbericht en redirect na 2 seconden
                $success['message'] = EMAIL_UPDATED;
                header('refresh:2;url=../index.php');
            }
        } else {
            // Wachtwoord klopt niet
            $errors['password'] = PASSWORD_INCORRECT;
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
    <title>Update Email</title>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h2>update email</h2>
            <br>
            <?php if(isset($success['message'])): ?>
                <div class="alert alert-success">
                    <?= $success['message'] ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="password">Current Password:</label>
                <input type="password" name="password" class="form-control" id="inputPassword">
                <div class="form-text text-danger">
                    <?=$errors['password'] ?? '' ?>
                </div>
                
                <label for="new_email">New Email:</label>
                <input type="email" name="new_email" class="form-control" id="inputNewEmail" value="<?=$inputs['new_email'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?=$errors['email'] ?? '' ?>
                </div>
                
                <br>
                <button type="submit" name="send">Update Email</button>
            </form>
            <div class="mt-3">
                <a href="../index.php">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html> 