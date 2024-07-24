<?php
$success = isset($_SESSION["success"]) ? $_SESSION["success"] : null;
$error = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
unset($_SESSION["success"]);
unset($_SESSION["error"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Intuji Assignment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Intuji Assignment</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        </ul>
        <?php if (!isset($_SESSION["code"])) : ?>
          <a href="<?= $googleOAuthUrl ?>">
            <button class="btn btn-sm btn-primary">
              Signin
            </button>
          </a>
        <?php else : ?>
          <form action="<?= BASE_URL . "/authHandler.php" ?>" method="POST">
            <button type="submit" class="btn btn-sm btn-danger" name="signout">
              Sign Out
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <div class="container pt-2">
    <?php if ($error) : ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> <?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if ($success) : ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> <?= $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>