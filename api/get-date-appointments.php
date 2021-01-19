<?php
require_once(__DIR__ . "/../utils/_init.php");
header("Content-Type: application/json; charset=UTF-8");

if(verify_get("date")){
  $date = $_GET["date"];
  $appointments = $appointmentStorage -> findAll(["day" => $date]);
  if (count($appointments) > 0) {
    http_response_code(200);
    $list = [];
    foreach ($appointments as $appointment) {
      array_push($list, $appointment);
    }
    print(json_encode($list));
  }else{
    http_response_code(200); // Parameters are correct but not exist on database can be 404
    print("[]");
  }
}else{
  http_response_code(400);
  print("[]");
}

?>
