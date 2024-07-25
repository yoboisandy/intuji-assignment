<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/services/googleClient.php';

use Services\GoogleClient;
// set the code from query in the session
if (isset($_GET["code"])) {
  $code = $_GET["code"];
  $gc = new GoogleClient();
  $token = $gc->getClient()->fetchAccessTokenWithAuthCode($code);
  if(isset($token["error"])) {
    $_SESSION["error"] = "Error: Authentication failed. Please try again.";
    header("Location: " . BASE_URL);
    exit();
  }
  $_SESSION["access_token"] = $token["access_token"];
  $_SESSION["success"] = "Successfully authenticated.";
  header("Location: " . BASE_URL);
  exit();
}

// handle if there is an error in google redirect link
if (isset($_GET["error"])) {
  $error = $_GET["error"];
  $_SESSION["error"] = "Error: Authentication failed. Please try again.";
  header("Location: " . BASE_URL);
  exit();
}

// signout
if (isset($_POST["signout"])) {
  unset($_SESSION["access_token"]);
  $_SESSION["success"] = "Successfully signed out.";
  header("Location: " . BASE_URL);
  exit();
}
