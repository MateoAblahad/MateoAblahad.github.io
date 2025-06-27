
<?php
include 'data.php';
global $db;

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $query = $db->prepare("SELECT * FROM reviews WHERE id = id");
        $query->execute(['id' => $id]);
        $laptop = $query->fetch(PDO::FETCH_ASSOC);
        if ($laptop) {
            if (isset($_POST['confirm'])) {
                $deleteQuery = $db->prepare("DELETE FROM reviews WHERE id = id");
                $deleteQuery->execute(['id' => $id]);
                header('Location: read.php');
            }
        } else {
            die("Review not found.");
        }
    } else {
        die("Unrecognised ID.");
    }
} else {
    die("ID missing.");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title></title>
</head>

<body>
<p>category: <?= ($laptop['category']) ?></p>
<p>merk: <?= ($laptop['merk']) ?>         </p>
<p>type: <?= ($laptop['type']) ?>         </p>
<p>memory: <?= ($laptop['memory']) ?>      </p>
<p>hd: <?= ($laptop['hd']) ?>               </p>
<p>Prijs: <?= ($laptop['prijs']) ?>        </p>
<form method="post">
    <button type="submit" name="confirm" class="btn btn-danger">Verwijderen</button>
    <a href="../../../../Users/302206491/OneDrive%20-%20ROC%20Mondriaan/Documenten/GitHub/php-stuff/secret_stash/read.php" class="btn btn-primary">Annuleren</a>
</form>

</body>
</body>
</html>