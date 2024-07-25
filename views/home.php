<?php
$googleClient = new Services\GoogleClient();
$calenderId = $_GET['cal'] ?? 'primary';
?>
<div>
  <div class="text-center">
    <h3>Google Calendar Events</h3>
  </div>
  <?php if (isset($_SESSION["access_token"])) : ?>
    <div>
      <div class="px-1 py-2 border">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link <?= $calenderId == 'primary' ? 'active' : '' ?>" aria-current="page" href="<?= BASE_URL . "?cal=primary" ?>">Primary</a>
          </li>
          <?php
          $calendars = $googleClient->getCalenders();
          foreach ($calendars as $calendar) {
            if ($calendar->primary) continue;
          ?>
            <li class="nav-item">
              <a class="nav-link <?= $calenderId == $calendar->id ? 'active' : '' ?>" aria-current="page" href="<?= BASE_URL . "?cal=$calendar->id" ?>"><?= $calendar->summary ?></a>
            </li>
          <?php
          }
          ?>
        </ul>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Event Name</th>
            <th>Start Time</th>
            <th>End Time</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $events = $googleClient->getEvents($calenderId);
          foreach ($events as $event) {
          ?>
            <tr>
              <td><?= $event->summary ?></td>
              <td><?= date('d M h:i A', strtotime($event->start->dateTime)) ?></td>
              <td><?= date('d M h:i A', strtotime($event->end->dateTime)) ?></td>
            </tr>
            </tr>
          <?php
          }
          if (count($events) == 0) {
          ?>
            <tr>
              <td colspan="3" class="text-center">No events found</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php endif ?>
</div>