<?php
require_once("utils/_init.php");

if(!$auth->authorize(["admin"])){
  redirect("index.php");
}

if(verify_post("day", "time", "limit")){

  if(empty($_POST["day"])){
    $errors[] = "day";
  }

  if(empty($_POST["time"])){
    $errors[] = "time";
  }

  if(empty($_POST["limit"])){
    $errors[] = "limit";
  }

  if(empty($errors)){
    $appointmentStorage -> add([
      "day" => $_POST["day"],
      "time" => $_POST["time"],
      "limit" => $_POST["limit"],
      "people" => []
    ]);

    redirect("index.php");
  }

}

?>

  <?php require_once("partials/head.php");?>
  <?php require_once("partials/header.php");?>

  <div class="forms">
    <h1>Post a new date</h1>
    <form method="post">

      <label for="day">Date*:</label><br>
      <?php if(in_array("day", $errors)) print("<span>Date should be entered!</span><br>");?>
      <input class="input_style" type="date" id="day" name="day" value="<?= $_POST["day"]?>"><br>

      <label for="time">Time*:</label><br>
      <?php if(in_array("time", $errors)) print("<span>Time should be entered!</span><br>");?>
      <input class="input_style" type="time" id="time" name="time" value="<?= $_POST["time"]?>"><br>

      <label for="limit">Total slots*:</label><br>
      <?php if(in_array("limit", $errors)) print("<span>Total slots should be entered!</span><br>");?>
      <input class="input_style" type="number" id="limit" name="limit" value="<?= $_POST["limit"]?>">

      <input type="submit" value="Post">
    </form>
  </div>

  <?php require_once("partials/footer.php")?>
