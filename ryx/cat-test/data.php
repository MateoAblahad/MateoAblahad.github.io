
<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=ecoins",
        "root", "");
} catch(PDOException $e) {
    die("Error!: " . $e->getMessage());
}
?>


