<?php
$googleClient = new Services\GoogleClient();
$calenderId = $_GET['cal'] ?? 'primary';
?>
<div>
  <div class="text-center">
    <h3>Upcoming Events</h3>
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
            <th>Action</th>
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
              <td>
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $event->id ?>">
                  Delete
                </button>
              </td>
            </tr>
            <div class="modal fade" id="exampleModal<?= $event->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this event?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form action="<?= BASE_URL . "/actions/deleteEvent.php" ?>" method="POST">
                      <input type="hidden" name="calendarId" value="<?= $calenderId ?>">
                      <input type="hidden" name="eventId" value="<?= $event->id ?>">
                      <button type="submit" class="btn btn-primary" name="delete_event">Yes</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          if (count($events) == 0) {
          ?>
            <tr>
              <td colspan="3" class="text-center">No upcoming events found in this calendar</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php endif ?>
</div>