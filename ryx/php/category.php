<?php 
include "db-accounts.php";
global $pdo;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Categories</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/category.css">
    <link rel="stylesheet" href="../css/footer.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Audiowide&family=Electrolize&family=Phudu:wght@300..900&family=Unbounded:wght@200..900&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    crossorigin="anonymous" />
</head>

<body class="body-category" style="margin: 0; padding: 0">
  <header>
        <?php include '../views/header.php';
        include("functions.php");
        loginMessage(true);
        ?>
    </header>

  <main class="container">
    <img src="../img/cat-header.jpg" class="img-fluid rounded-top w-100 mb-3" alt="Category header image"
      style="max-height: 430px; object-fit: cover;" />

    <div class="row justify-content-center g-4">
      <div class="col-md-3 col-sm-6">
        <div class="card text-white-50 bg-dark h-100">
          <a href="bitcoin.php" style="text-decoration: none; color: inherit;">
            <img class="card-img-top w-100" src="../img/bitcoin-card.jpg" alt="Bitcoin card" />
            <div class="card-body text-center">
              <h4 class="card-title">Bitcoin</h4>
              <p class="card-text">What is Bitcoin and what is it for?</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="card text-white-50 bg-dark h-100">
          <a href="ethereum.php" style="text-decoration: none; color: inherit;">
            <img class="card-img-top w-100" src="../img/ethereum-card.jpg" alt="Ethereum card" />
            <div class="card-body text-center">
              <h4 class="card-title">Ethereum</h4>
              <p class="card-text">Eth and its many uses in daily life</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="card text-white-50 bg-dark h-100">
          <a href="tether.php" style="text-decoration: none; color: inherit;">
            <img class="card-img-top w-100" src="../img/tether-card.png" alt="Tether card" />
            <div class="card-body text-center">
              <h4 class="card-title">Tether</h4>
              <p class="card-text">The coin tethered to USD!</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="card text-white-50 bg-dark h-100">
          <a href="monero.php" style="text-decoration: none; color: inherit;">
            <img class="card-img-top w-100" src="../img/monero-card.jpg" alt="Monero card" />
            <div class="card-body text-center">
              <h4 class="card-title">Monero</h4>
              <p class="card-text">A lesser known coin!</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </main>

  <footer class="text-center py-4">
      <?php include '../views/footer.php'; ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>


