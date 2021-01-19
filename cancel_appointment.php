<?php
require_once("utils/_init.php");

foreach($appointmentStorage -> findAll() as $app) {
  for($i=0; $i<count($app["people"]); $i++) {
    if($app["people"][$i] == $auth->authenticated_user()["id"]){
      unset($app["people"][$i]);
      $appointmentStorage -> update($app["id"], $app);
    }
  }
}

redirect("index.php");
