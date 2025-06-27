<?php
require "db-accounts.php";
$coinId = 4;
$coin = $pdo->prepare("SELECT * FROM coins WHERE id = ?");
$coin->execute([$coinId]);
$coin = $coin->fetch(PDO::FETCH_ASSOC);
if (!$coin) { exit("Coin not found"); }

$errors = [];
$inputs = [];

if (isset($_POST['submit'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_SPECIAL_CHARS);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);

    if (!$name) $errors['name'] = "Enter your name.";
    else $inputs['name'] = $name;

    if (!$review) $errors['review'] = "Write a review.";
    else $inputs['review'] = $review;

    if ($rating === false || $rating < 1 || $rating > 5) $errors['rating'] = "Rating must be 1–5 stars.";
    else $inputs['rating'] = $rating;

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO reviews (name, review, rating, coin_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $review, $rating, $coinId]);
        header("Location: monero.php");
        exit;
    }
}

$reviews = $pdo->prepare("SELECT name, review, rating FROM reviews WHERE coin_id = ? ORDER BY id DESC");
$reviews->execute([$coinId]);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8"><title><?= $coin['name'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .stars { display: flex; flex-direction: row-reverse; justify-content: flex-end; }
    .stars input { display: none; }
    .stars label { font-size: 2rem; color: lightgray; cursor: pointer; }
    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label { color: gold; }
  </style>
</head>
<body class="bg-dark text-light">
<?php include '../views/header.php';  ?>
<main class="container py-4">
  <h1><?= htmlspecialchars($coin['name']) ?></h1>
  <p><?= htmlspecialchars($coin['description']) ?></p>

  <?php if ($reviews->rowCount()): ?>
    <h4>Previous Reviews</h4>
    <table class="table table-striped table-dark">
      <thead><tr><th>Name</th><th>Review</th><th>Rating</th></tr></thead>
      <tbody>
        <?php foreach ($reviews as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td><?= htmlspecialchars($r['review']) ?></td>
            <td><?= str_repeat('★', $r['rating']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No reviews yet – be the first!</p>
  <?php endif; ?>

  <h4 class="mt-4">Leave a Review</h4>
  <form method="POST" class="bg-secondary p-3 rounded">
    <div class="mb-3">
      <label>Your Name:</label>
      <input type="text" name="name" class="form-control" value="<?= $inputs['name'] ?? '' ?>">
      <small class="text-warning"><?= $errors['name'] ?? '' ?></small>
    </div>
    <div class="mb-3">
      <label>Rating:</label>
      <div class="stars">
        <?php for ($i=5; $i>=1; $i--): ?>
          <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= (isset($inputs['rating']) && $inputs['rating']==$i ? 'checked' : '') ?>>
          <label for="star<?= $i ?>">★</label>
        <?php endfor; ?>
      </div>
      <small class="text-warning"><?= $errors['rating'] ?? '' ?></small>
    </div>
    <div class="mb-3">
      <label>Your Review:</label>
      <textarea name="review" class="form-control"><?= $inputs['review'] ?? '' ?></textarea>
      <small class="text-warning"><?= $errors['review'] ?? '' ?></small>
    </div>
    <button type="submit" name="submit" class="btn btn-success">Submit Review</button>
  </form>
</main>
<?php include '../views/footer.php'; ?>
</body>
</html>
