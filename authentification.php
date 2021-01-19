<?php

require_once("utils/_init.php");

if(count($_POST) > 0){
  if(verify_post("email", "password")){

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $user = $auth->authenticate($email, $password);
    if ($user === NULL) {
      $errors[] = "invalid";
    }

    if (empty($errors)) {
      $auth->login($user);
      if(count($_COOKIE["appointment"]) > 0){
        redirect("book.php");
      }else{
        redirect("index.php");
      }
    }

  }else if(verify_post("name", "snn", "address", "email", "new-password", "confirmation")){

    $name = trim($_POST["name"]);
    $snn = $_POST["snn"];
    $address = trim($_POST["address"]);
    $email = trim($_POST["email"]);
    $new_password = trim($_POST["new-password"]);
    $confirmation = trim($_POST["confirmation"]);

    if(empty($name)){
      $errors[] = "name";
    }

    if(!(is_numeric($snn) && strlen((string)$snn) == 9)){
      $errors[] = "snn";
    }

    if(empty($address)){
      $errors[] = "address";
    }

    if(empty($email)){
      $errors[] = "emptyEmail";
    }

    if ($auth -> user_exists($email)) {
      $errors[] = "existedEmail";
    }

    if($new_password !== $confirmation){
      $errors[] = "password";
    }

    if(empty($errors)){

      $auth->register([
        "email" => $email,
        "password" => $new_password,
        "name" => $name,
        "snn" => $snn,
        "address" => $address
      ]);

      $user = $auth->authenticate($email, $new_password);
      $auth->login($user);

      if(count($_COOKIE["appointment"]) > 0){
        redirect("book.php");
      }else{
        redirect("index.php");
      }

    }
  }
}

?>

    <?php require_once("partials/head.php");?>
    <?php require_once("partials/header.php");?>

    <div class="forms">
        <h1>Sign in</h1>
        <form method="post">

          <?php if(verify_post("email", "password") && in_array("invalid", $errors)) print("<span>Invalid email or password!</span><br>");?>
      	  <input class="input_style" autocomplete="off" type="email" name="email" placeholder="Your e-mail" value="<?php if(verify_post("email", "password")) print($_POST["email"]);?>"><br>

          <input class="input_style" type="password" name="password" placeholder="password">

          <input type="submit" value="Sign in">

        </form>
      <hr>
        <h1>Create an account</h1>
        <form method="post">

          <?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation") && in_array("name", $errors)) print("<span>Name must be not empty!</span><br>");?>
      	  <input class="input_style" autocomplete="off" type="text" name="name" placeholder="Your full name*" value="<?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation")) print($_POST["name"]);?>"><br>

          <?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation") && in_array("snn", $errors)) print("<span>Snn should be 9 character long number!</span><br>");?>
      	  <input class="input_style" autocomplete="off" type="text" name="snn" placeholder="SSN number*" value="<?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation")) print($_POST["snn"]);?>"><br>

          <?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation") && in_array("address", $errors)) print("<span>Address must be not empty!</span><br>");?>
      	  <input class="input_style" autocomplete="off" type="text" name="address" placeholder="Address*" value="<?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation")) print($_POST["address"]);?>"><br>

          <?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation") && in_array("emptyEmail", $errors)) print("<span>E-mail must be not empty!</span><br>");?>
          <?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation") && in_array("existedEmail", $errors)) print("<span>Email already exist!</span><br>");?>
      	  <input class="input_style" autocomplete="off" type="email" name="email" placeholder="e-mail*" value="<?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation")) print($_POST["email"]);?>"><br>

          <?php if(verify_post("name", "snn", "address", "email", "new-password", "confirmation") && in_array("password", $errors)) print("<span>Password not matched!</span><br>");?>
      	  <input class="input_style" type="password" name="new-password" placeholder="password*">
      	  <input class="input_style" type="password" name="confirmation" placeholder="confirm the password">

          <input type="submit" value="Register">

        </form>
    </div>

    <?php require_once("partials/footer.php")?>
