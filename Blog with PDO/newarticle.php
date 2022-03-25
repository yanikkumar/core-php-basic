<?php

  require('classes/Database.php');
  require('classes/Article.php');
  require('classes/Url.php');
  require('classes/Auth.php');

  session_start();

  if( ! Auth::isLoggedIn()) {
    die("unauthorized");
  }

  $article = new Article();

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $conn = $db->getConn();

    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    if ($article->create($conn))
    {
      Url::redirect("/Blog with PDO/article.php?id={$article->id}");
    }

  }

?>

<?php require('include/header.php') ?>

<h2>New Article</h2>

<?php require('include/articleform.php') ?>

<?php require('include/footer.php') ?>
