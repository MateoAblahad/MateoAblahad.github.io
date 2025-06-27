<?php

include 'data.php';
global $db;


$errorCategory="";
$errorMerk="";
$errorType="";
$errorMemory="";
$errorHd="";
$errorPrijs="";
if (isset($_POST['send'])) {
    $category=filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
    $merk=filter_input(INPUT_POST,'merk', FILTER_SANITIZE_SPECIAL_CHARS);
    $type=filter_input(INPUT_POST,'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $memory=filter_input(INPUT_POST,'memory', FILTER_SANITIZE_NUMBER_INT);
    $hd=filter_input(INPUT_POST,'hd', FILTER_SANITIZE_NUMBER_INT);
    $prijs=filter_input(INPUT_POST,'prijs', FILTER_VALIDATE_FLOAT);
    if (empty($category)) {
        $errorCategory="Category invullen";
    }
    if (empty($merk)) {
        $errorMerk="Merk invullen";
    }
    if (empty($type)) {
        $errorType="type invullen";
    }
    if (empty($memory)) {
        $errorMemory="Memory invullen";
    }
    if (empty($hd)) {
        $errorHd="HD invullen";
    }
    if ($prijs===false) {
        $errorPrijs="Prijs invullen";
    }
    if ($errorCategory=="" &&  $errorMerk=="" &&$errorType=="" && $errorMemory=="" && $errorHd=="" && $errorPrijs=="") {
        $query = $db->prepare("INSERT INTO laptops (category, merk,type,memory,hd, prijs) VALUES  (:category , :merk,:type,:memory, :hd,:prijs)");
        $query->bindParam(':category', $category);
        $query->bindParam(':merk', $merk);
        $query->bindParam(':type', $type);
        $query->bindParam(':memory', $memory);
        $query->bindParam(':hd', $hd);
        $query->bindParam(':prijs', $prijs);
        $query->execute();
        header('Location: read.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table {
        border-collapse: collapse;
        border: 1px solid black;
    }
    td {
        border: 1px solid black;
        width: 300px;
        text-align: center;
    }
</style>
<body>
<form method="post" action="">
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
            <?=$errorCategory?>
        </div>
        <label for="n" class="form-label">Merk</label>
        <input type="text" class="form-control" id="n" name="merk" value="<?=$_POST['merk'] ?? ''?>">
        <div class="form-text text-danger">
            <?=$errorMerk?>
        </div>
    </div>
    <div class="mb-3">
        <label for="n" class="form-label">type</label>
        <input type="text" class="form-control" id="n" name="type" value="<?=$_POST['type'] ?? ''?>">
        <div class="form-text text-danger">
            <?=$errorType?>
        </div>
    </div>
    <div class="mb-3">
        <label for="n" class="form-label">memory</label>
        <input type="text" class="form-control" id="n" name="memory" value="<?=$_POST['memory'] ?? ''?>">
        <div class="form-text text-danger">
            <?=$errorMemory?>
        </div>
    </div>
    <div class="mb-3">
        <label for="n" class="form-label">Hd</label>
        <input type="text" class="form-control" id="n" name="hd" value="<?=$_POST['hd'] ?? ''?>">
        <div class="form-text text-danger">
            <?=$errorHd?>
        </div>
    </div>
    <div class="mb-3">
        <label for="n" class="form-label">prijs</label>
        <input type="text" class="form-control" id="n" name="prijs" value="<?=$_POST['prijs'] ?? ''?>">
        <div class="form-text text-danger">
            <?=$errorPrijs?>
        </div>
    </div>
    <input type="submit" class="btn btn-primary" name="send" value="Toevoegen">
</form>
</body>
</html>