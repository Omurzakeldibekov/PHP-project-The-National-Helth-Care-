<?php
require_once("utils/_init.php");
if(!empty($errors)): ?>
  <div class="errors">
    <?php foreach($errors as $err): ?>
      <p><?= $err ?></p>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
