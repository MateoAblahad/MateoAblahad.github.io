
<?php
include 'data.php';
global $db;



const CATEGORY_REQUIRED = 'Category invullen';
const MERK_REQUIRED = 'merk invullen';
const TYPE_REQUIRED = 'type invullen';
const MEMORY_REQUIRED = 'memory invullen';
const HD_REQUIRED = 'hd invullen';
const PRIJS_REQUIRED = 'prijs invullen';

$errors = [];
$inputs = [];

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $query = $db->prepare("SELECT * FROM laptops WHERE id = :id");
        $query->execute(['id' => $id]);
        $laptops = $query->fetch(PDO::FETCH_ASSOC);
        if ($laptops) {
            $inputs = $laptops;
        }
    }
}
if (isset($_POST['send'])) {
    $id = $_POST['id'];
    $category=filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
    $inputs['category'] = $category;
    $category = trim($category);
    if (empty($category)) {
        $errors['category'] = CATEGORY_REQUIRED;
    }

    $merk=filter_input(INPUT_POST,'merk', FILTER_SANITIZE_SPECIAL_CHARS);
    $inputs['merk'] = $merk;
    $merk = trim($merk);
    if (empty($merk)) {
        $errors['merk'] = MERK_REQUIRED;
    }
    $type=filter_input(INPUT_POST,'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $inputs['type'] = $type;
    $type = trim($type);
    if (empty($type)) {
        $errors['type'] = TYPE_REQUIRED;
    }
    $memory=filter_input(INPUT_POST,'memory', FILTER_SANITIZE_NUMBER_INT);
    $inputs['memory'] = $memory;
    $memory = trim($memory);
    if (empty($memory)) {
        $errors['memory'] = MEMORY_REQUIRED;
    }
    $hd=filter_input(INPUT_POST,'hd', FILTER_SANITIZE_NUMBER_INT);
    $inputs['hd'] = $hd;
    $hd = trim($hd);
    if (empty($hd)) {
        $errors['hd'] = HD_REQUIRED;
    }
    $prijs=filter_input(INPUT_POST,'prijs', FILTER_VALIDATE_FLOAT);
    $inputs['prijs'] = $prijs;
    $prijs = trim($prijs);
    if (empty($prijs)) {
        $errors['prijs'] = PRIJS_REQUIRED;
    }
    if (count($errors) == 0) {
        $query = $db->prepare("UPDATE laptops SET category = :category ,merk = :merk, type=:type ,memory = :memory, hd=:hd, prijs=:prijs WHERE id = :id");
        $query->bindParam('category', $inputs['category']);
        $query->bindParam('merk', $inputs['merk']);
        $query->bindParam('type', $inputs['type']);
        $query->bindParam('memory', $inputs['memory']);
        $query->bindParam('hd', $inputs['hd']);
        $query->bindParam('prijs', $inputs['prijs']);
        $query->bindParam('id', $id);
        $query->execute();
        header('Location: read.php');
    }
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
<form method="post" action="">
    <input type="hidden" name="id" value="<?= $inputs['id'] ?? '' ?>">
    <div class="mb-3">
        <label for="laptops">kies een category:</label>

        <select id="laptops" type="text" class="form-control" id="n" name="category" value="<?=$_POST['category'] ?? ''?>">
            <option value="Ultrabooks">Ultrabooks</option>
            <option value="Gaming laptops">Gaming laptops</option>
            <option value="Chromebooks">Chromebooks</option>
            <option value="2-in-1 laptops" >2-in-1 laptops</option>
            <option value="Zakelijke laptops" >Zakelijke laptops</option>
        </select>
        <div class="form-text text-danger">
            <?= $errors['category'] ?? '' ?>
        </div>
    <div class="mb-3">
        <label for="r" class="form-label">Merk</label>
        <input type="text" class="form-control" id="r" name="merk" value="<?= $inputs['merk'] ?? '' ?>">
        <div class="form-text text-danger"><?= $errors['merk'] ?? '' ?></div>
    </div>
    <div class="mb-3">
        <label for="p" class="form-label">Type</label>
        <input type="text" class="form-control" id="p" name="type" value="<?= $inputs['type'] ?? '' ?>">
        <div class="form-text text-danger"><?= $errors['type'] ?? '' ?></div>
    </div>
        <div class="mb-3">
            <label for="p" class="form-label">Memory</label>
            <input type="text" class="form-control" id="p" name="memory" value="<?= $inputs['memory'] ?? '' ?>">
            <div class="form-text text-danger"><?= $errors['memory'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="p" class="form-label">Hd</label>
            <input type="text" class="form-control" id="p" name="hd" value="<?= $inputs['hd'] ?? '' ?>">
            <div class="form-text text-danger"><?= $errors['hd'] ?? '' ?></div>
        </div>
        <div class="mb-3">
            <label for="p" class="form-label">Prijs</label>
            <input type="text" class="form-control" id="p" name="prijs" value="<?= $inputs['prijs'] ?? '' ?>">
            <div class="form-text text-danger"><?= $errors['prijs'] ?? '' ?></div>
        </div>

    <input type="submit" name="send"  class="btn btn-primary" value="Updaten">
</form>
</body>
</html>