<?php

namespace Services;

use Google_Client;
use Google_Service_Calendar;

class GoogleClient
{
  private $client;

  public function __construct()
  {
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../config.php';

    $this->client = new Google_Client();
    $this->client->setClientId(GOOGLE_CLIENT_ID);
    $this->client->setClientSecret(GOOGLE_CLIENT_SECRET);
    $this->client->setRedirectUri(REDIRECT_URI);
    $this->client->addScope(GOOGLE_OAUTH_SCOPE);
  }

  public function getClient()
  {
    return $this->client;
  }

  public function getEvents($calendarId)
  {
    $this->client->setAccessToken($_SESSION["access_token"]);
    $service = new Google_Service_Calendar($this->client);
    $events = $service->events->listEvents($calendarId, [
      'orderBy'      => 'startTime',
      'singleEvents' => true,
      'timeMin'      => date('c'),
    ]);
    return $events->getItems();
  }

  public function getCalenders()
  {
    $this->client->setAccessToken($_SESSION["access_token"]);
    $service = new Google_Service_Calendar($this->client);
    $calendarList = $service->calendarList->listCalendarList();
    return $calendarList;
  }

  public function deleteEvent($calendarId, $eventId)
  {
    try {
      $this->client->setAccessToken($_SESSION["access_token"]);
      $service = new Google_Service_Calendar($this->client);
      $service->events->delete($calendarId, $eventId);
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function addEvent($calendarId, $event)
  {
    try {
      $this->client->setAccessToken($_SESSION["access_token"]);
      $service = new Google_Service_Calendar($this->client);
      return $service->events->insert($calendarId, $event);
    } catch (\Exception $e) {
      return ["error" => $e->getMessage()];
    }
  }
}
