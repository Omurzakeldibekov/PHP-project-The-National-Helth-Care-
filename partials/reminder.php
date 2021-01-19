<?php
require_once("utils/_init.php");
foreach ($appointmentStorage -> findAll() as $app) {
  foreach ($app["people"] as $peopleId) {
    if($peopleId == $auth->authenticated_user()["id"]){
      $myAppointment = $app;
    }
  }
}
if(isset($myAppointment)):
?>
  <div class="reminder">
    Your appointment: <?= $myAppointment["day"]?> at <?= $myAppointment["time"]?>
    <a href="cancel_appointment.php">Cancel appointment</a>
  </div>
<?php endif;?>
