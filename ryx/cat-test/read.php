
<?php
include 'data.php';
global $db;

$query = $db->prepare("SELECT * FROM laptops");
$query->execute();
$smartphone = $query->fetchAll(PDO:: FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title></title>
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
<table>
    <h1>Laptop CRUD</h1>
    <tr>
        <th>category</th>
        <th>merk</th>
        <th>type</th>
        <th>Detelis</th>
        <th>Update</th>
        <th>Monkey Cage</th>
    </tr>
    <?php foreach ($smartphone as $data): ?>
        <tr>
            <td><?= $data ['category'] ?></td>
            <td><?= $data ['merk'] ?></td>
            <td><?= $data ['type'] ?></td>
            <td><a href="details.php?id=<?= $data ['id'] ?>"><i class="bi bi-search"></i></a></td>
            <td><a href="../../../../Users/302206491/OneDrive%20-%20ROC%20Mondriaan/Documenten/GitHub/php-stuff/secret_stash/update.php?id=<?= $data ['id'] ?>"><i class="bi bi-pencil-square"></i></a></td>
            <td><a href="deleted.php?id=<?= $data ['id'] ?>"><i class="bi bi-trash"></i></a></td>
        </tr>
    <?php endforeach; ?>
    <td><a href="insert.php"><i class="bi bi-plus-square"></i></a></td>
</table>
</body>
</html>
