<?php

require('../include/init.php');
Auth::requireLogin();

$conn = require('../include/db.php');

$paginator = new Paginator($_GET['page'] ?? 1, 3, Article::getTotal($conn)); // In php 7 with null coalasing operator.
$articles = Article::getPage($conn, $paginator->limit, $paginator->offset);

?>

<?php include("../include/header.php") ?>

<h3>Admin</h3>
<p><a href="newarticle.php">New Article</a></p>

<?php if (empty($articles)): ?>
  <p>No Articles Found.</p>
<?php else: ?>
  <table>
    <thead>
      <th>Title</th>
      <th>Published At</th>
    </thead>
    <tbody>
    <?php foreach ($articles as $article): ?>
      <tr>
        <td class="">
          <a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a>
        </td>
        <td>
          <time datetime="<?= $article['published_at'] ?>">
            <?php if ($article['published_at']): ?>
              <?php
                $dateTime = new DateTime($article['published_at']);
                echo $dateTime->format("j F, Y");
              ?>
            <?php else: ?>
              Unpublished
            <?php endif; ?>

          </time>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <?php require('../include/pagination.php'); ?>

<?php endif; ?>

<?php include('../include/footer.php'); ?>
