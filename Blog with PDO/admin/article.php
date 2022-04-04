<?php
// CRUD OPERATION IMPLEMENTED

require('../include/init.php');

Auth::requireLogin();

$conn = require('../include/db.php');

if(isset($_GET['id']))
{
  $article = Article::getById($conn, $_GET['id']);
} else {
  $article = null;
}

?>

<?php include('../include/header.php'); ?>

  <?php if ($article): ?>
    <article>
      <h2><?= htmlspecialchars($article->title); ?></h2>

      <?php if ($article->image_file): ?>
        <img src="/Blog with PDO/uploads/<?= $article->image_file; ?>">
      <?php endif; ?>
      
      <p><?= htmlspecialchars($article->content); ?></p>
    </article>

    <a href="editarticle.php?id=<?= $article->id ?>">Edit</a>
    <a href="deletearticle.php?id=<?= $article->id ?>">Delete</a>
    <a href="editarticleimage.php?id=<?= $article->id ?>">Edit Image</a>
  <?php else: ?>
    <p>No Article Found</p>
  <?php endif; ?>

<?php include('../include/footer.php'); ?>
