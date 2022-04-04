<?php

require('../include/init.php');

Auth::requireLogin();

$conn = require('../include/db.php');

if(isset($_GET['id']))
{
  $article = Article::getById($conn, $_GET['id']);

  if(! $article) {
    die("Article Not Found!");
  }
} else {
  die("id not supplied, article not found");
}

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_FILES);

    try {
      if(empty($_FILES)) {
        throw new Exception('Invalid upload');
      }

      switch($_FILES['file']['error']) {
        case UPLOAD_ERR_OK:
          break;

        case UPLOAD_ERR_NO_FILE:
          throw new Exception('No file uploaded');
          break;

        case UPLOAD_ERR_INI_SIZE:
          throw new Exception('File is too large (from server settings)');
          break;

        default:
          throw new Exception('An Error Occured');
      }
      if($_FILES['file']['size'] > 1000000) {
        throw new Exception('File is too large');
      }

      $mime_types = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'];
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

      if (! in_array($mime_type, $mime_types)) {
        throw new Exception('Invalid file type');
      }

    } catch (Exception $e) {
      echo $e->getMessage();
    }

  }

?>

<?php require('../include/header.php') ?>

<h2>Edit Article Image</h2>
<form method="post" enctype="multipart/form-data">
  <div>
    <label for="file">Image:</label>
    <input type="file" name="file" id="file">
  </div>

  <button>Upload</button>
</form>

<?php require('../include/footer.php') ?>
