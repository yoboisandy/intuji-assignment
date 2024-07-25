<?php
session_start();
require_once __DIR__ . '/../services/googleClient.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Services\GoogleClient;
use Google_Service_Calendar_Event;

if (isset($_POST["add_event"])) {
  $gc = new GoogleClient();
  $event = new Google_Service_Calendar_Event([
    'summary' => $_POST["event_name"],
    'description' => $_POST["description"],
    'start' => ['dateTime' => $_POST["start_time"] . ':00', 'timeZone' => $_POST["timezone"]],
    'end' => ['dateTime' => $_POST["end_time"] . ':00', 'timeZone' => $_POST["timezone"]],
  ]);
  $event = $gc->addEvent($_POST["calendarId"], $event);
  if (!isset($event["error"])) {
    $_SESSION["success"] = "Event added successfully.";
  } else {
    $_SESSION["error"] = $event["error"];
  }
  header("Location: " . BASE_URL);
  exit();
}
