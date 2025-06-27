

<?php
include 'data.php';
global $db;
//$id=$_GET['id'];
$query = $db->prepare('SELECT * FROM coins WHERE id');
$query -> bindParam("id", $id);
//$query->execute();
$result = $query->fetchAll( PDO::FETCH_ASSOC);
?>
<?php foreach ($result as $data):?>
    <div class="card " style="width: 25rem;">
        <h3>Coin File: <?=$data ['id'] ?></h3>
        <h2>Coin name: <?=$data ['name'] ?></h2>
        <h3>Coin description:</h3>
        <p class="mb-2"><?=$data ['description'] ?></p>
        <p class="mb-2"><?=$data ['img'] ?></p>
    </div>
<?php endforeach; ?>
<br>
<a href="../../../../Users/302206491/OneDrive%20-%20ROC%20Mondriaan/Documenten/GitHub/php-stuff/secret_stash/read.php">Terug naar home pagina</a>