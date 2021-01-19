<?php
require_once("utils/_init.php");

foreach($appointmentStorage -> findAll() as $app) {
  for($i=0; $i<count($app["people"]); $i++) {
    if($app["people"][$i] == $auth->authenticated_user()["id"]){
      array_splice($app["people"], $i, 1);
      $appointmentStorage -> update($app["id"], $app);
    }
  }
}

redirect("index.php");
