<?php
session_start();
require_once __DIR__ . '/../services/googleClient.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Services\GoogleClient;

$gc = new GoogleClient();

if (isset($_POST["delete_event"])) {
  $gc->deleteEvent($_POST["calendarId"], $_POST["eventId"]);
  $_SESSION["success"] = "Event deleted successfully.";
  header("Location: " . BASE_URL);
  exit();
}