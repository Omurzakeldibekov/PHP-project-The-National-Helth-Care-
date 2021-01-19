<?php require_once("utils/_init.php");?>

<div class="header">
  <a href="index.php" class="logo">The National Health Centre</a>
  <div class="header-right">
    <?php if($auth->is_authenticated()): ?>
      <?php if($auth->authorize(["admin"])):?>
        <a class="button" href="new-date.php">Post a new date</a>
      <?php endif;?>
      <a class="button" href="logout.php">Log out (<?= $auth->authenticated_user()["name"] ?>)</a>
    <?php else: ?>
      <a class="button" href="authentification.php"><b>Log in</b></a>
    <?php endif; ?>
  </div>
</div>
