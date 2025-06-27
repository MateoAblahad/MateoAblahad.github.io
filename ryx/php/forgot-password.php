<?php
    include 'db-accounts.php';

const EMAIL_REQUIRED = 'Enter your email.';
const PASSWORD_REQUIRED = 'Enter your new password.';
const EMAIL_NOT_FOUND = 'No account found with this email.';
const PASSWORD_UPDATED = 'Password has been updated successfully.';

$errors = [];
$success = [];
$inputs = [];

if(isset($_POST['send'])){
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = trim($email);

    if(empty($email)){
        $errors['email'] = EMAIL_REQUIRED;
    } else {
        $inputs['email'] = $email;
        
        // Check if email exists
        global $pdo;
        $query = $pdo->prepare('SELECT * FROM accounts WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        
        if(!$query->fetch()){
            $errors['email'] = EMAIL_NOT_FOUND;
        }
    }

    $newPassword = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS);
    $newPassword = trim($newPassword);

    if(empty($newPassword)){
        $errors['password'] = PASSWORD_REQUIRED;
    }

    if(count($errors) === 0){
        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = $pdo->prepare('UPDATE accounts SET password = :password WHERE email = :email');
        $updateQuery->bindParam(':password', $hashedPassword);
        $updateQuery->bindParam(':email', $email);
        
        if($updateQuery->execute()){
            $success['message'] = PASSWORD_UPDATED;
            header('refresh:2;url=../index.php');
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
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h2>reset password</h2>
            <br>
            <?php if(isset($success['message'])): ?>
                <div class="alert alert-success">
                    <?= $success['message'] ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="email">E-mail:</label>
                <input type="email" name="email" class="form-control" id="inputEmail" value="<?=$inputs['email'] ?? '' ?>">
                <div class="form-text text-danger">
                    <?=$errors['email'] ?? '' ?>
                </div>
                
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" class="form-control" id="inputNewPassword">
                <div class="form-text text-danger">
                    <?=$errors['password'] ?? '' ?>
                </div>
                
                <br>
                <button type="submit" name="send">Reset Password</button>
            </form>
            <div class="mt-3">
                <a href="../index.php">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html> 