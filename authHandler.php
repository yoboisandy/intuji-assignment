<?php
session_start();
require_once __DIR__ . '/config.php';

// set the code from query in the session
if (isset($_GET["code"])) {
  $code = $_GET["code"];
  $_SESSION["code"] = $code;
  $_SESSION["success"] = "Successfully authenticated.";
  header("Location: " . BASE_URL);
}

// handle if there is an error in google redirect link
if (isset($_GET["error"])) {
  $error = $_GET["error"];
  $_SESSION["error"] = "Error: Authentication failed. Please try again.";
  header("Location: " . BASE_URL);
}

// signout
if (isset($_POST["signout"])) {
  session_destroy();
  $_SESSION["success"] = "Successfully signed out.";
  header("Location: " . BASE_URL);
}

