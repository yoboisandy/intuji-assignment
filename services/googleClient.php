<?php
namespace Services;

use Google_Client;
use Google_Service_Calendar;

class GoogleClient {
  private $client;

  public function __construct() {
    require_once './vendor/autoload.php';
    require_once 'config.php';

    $this->client = new Google_Client();
    $this->client->setClientId(GOOGLE_CLIENT_ID);
    $this->client->setClientSecret(GOOGLE_CLIENT_SECRET);
    $this->client->setRedirectUri(REDIRECT_URI);
    $this->client->addScope(GOOGLE_OAUTH_SCOPE);
  }

  public function getClient() {
    return $this->client;
  }

  public function getEvents($calendarId) {
    $this->client->setAccessToken($_SESSION["access_token"]);
    $service = new Google_Service_Calendar($this->client);
    $events = $service->events->listEvents($calendarId);
    return $events;
  }
}