<?php
require_once("utils/_init.php");
require_once("partials/reminder.php");

if(isset($myAppointment)){
  redirect("index.php");
}

if(!$auth->is_authenticated()){
  setcookie('appointment', $_POST["appointment"]);
  redirect("authentification.php");
}else if(!empty($_COOKIE["appointment"])){
  $appointment = $appointmentStorage -> findById($_COOKIE["appointment"]);
  setcookie('appointment', "");
}else if(verify_post("confirmed_appointment")){

  $appointment = $appointmentStorage -> findById($_POST["confirmed_appointment"]);

  if(!verify_post("approval")){
    $errors[] = "Please, accept the terms and conditions!";
  }

  if(count($appointment["people"]) >= $appointment["limit"]){
    $errors[] = "Sorry, the appointment currently full. Please, <a href='index.php'>choose other date</a>";
  }

  if(empty($errors)){
    array_push($appointment["people"], $auth->authenticated_user()["id"]);
    $appointmentStorage -> update($appointment["id"], $appointment);
    redirect("index.php");
  }

}else if(verify_post("appointment")){
  $appointment = $appointmentStorage -> findById($_POST["appointment"]);
}else{
  redirect("index.php");
}

?>

    <?php require_once("partials/head.php");?>
    <?php require_once("partials/errors.php");?>

    <div class="book">
      <h1>Apointment for <?= $appointment["day"]?> at <?= $appointment["time"]?></h1>
      <?php if($auth->authorize(["admin"])):?>
        <table>
          <tr>
            <th>name</th>
            <th>SNN</th>
            <th>E-mail</th>
          </tr>
          <?php foreach($appointment["people"] as $patientId):
            $patient = $userStorage -> findById($patientId);
          ?>
            <tr>
              <td><?= $patient["name"]?></td>
              <td><?= $patient["snn"]?></td>
              <td><?= $patient["email"]?></td>
            </tr>
          <?php endforeach;?>
        </table>
      <?php else:?>
        <span>Name: <b><?= $auth->authenticated_user()["name"]?></b></span><br>
        <span>Address: <b><?= $auth->authenticated_user()["address"]?></b></span><br>
        <span>SSN number: <b><?= $auth->authenticated_user()["snn"]?></b></span><br>
        <form method="post">
          <input type="hidden" name="confirmed_appointment" value="<?= $appointment["id"] ?>">
          <input type="checkbox" id="approval" name="approval" value="false">
          <label for="approval"> It is mandatory to show up on the appointment after booking it! There may be side effects of vaccination. Please, contact us for more questions.</label><br>
          <input type="submit" value="Confirm">
        </form>
      <?php endif;?>
    </div>

    <?php require_once("partials/footer.php")?>
