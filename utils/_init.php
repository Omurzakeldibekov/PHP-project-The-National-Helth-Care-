<?php
session_start();

require_once("input.inc.php");

require_once("storage.inc.php");
require_once("auth.inc.php");
require_once("flash.inc.php");
require_once("navigation.inc.php");

$userStorage = new Storage(new JsonIO(__DIR__ . "/../data/users.json"));
$appointmentStorage = new Storage(new JsonIO(__DIR__ . "/../data/appointments.json"));


$auth = new Auth($userStorage);

$errors = load_from_flash("errors", []);
