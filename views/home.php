<?php
$googleClient = new Services\GoogleClient();
$calenderId = $_GET['cal'] ?? 'primary';
?>
<div>
  <div class="text-center py-4">
    <h3>Upcoming Events</h3>
  </div>
  <?php if (isset($_SESSION["access_token"])) : ?>
    <div>
      <div class="p-2 border d-flex justify-content-between align-items-center">
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
        <div>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Event
          </button>
        </div>
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
              <td colspan="4" class="text-center">No upcoming events found in this calendar</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="text-center">
      <a href="<?= OAUTH_REDIRECT_URI ?>" class="btn btn-danger">Login with Google</a>
      <div class="py-3">
        To view upcoming events
      </div>
    </div>
  <?php endif; ?>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form action="<?= BASE_URL . "/actions/addEvent.php" ?>" method="POST">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Event</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="event_name" name="event_name" required>
          </div>
          <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
          </div>
          <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
          </div>
          <div class="mb-3">
            <label for="timezone" class="form-label">Timezone</label>
            <select class="form-select" id="timezone" name="timezone" required>
              <option value="Asia/Kolkata">Asia/Kolkata</option>
              <option value="America/Los_Angeles">America/Los_Angeles</option>
              <!-- others -->
            </select>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
          </div>
          <input type="hidden" name="calendarId" value="<?= $calenderId ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" name="add_event">Add</button>
        </div>
      </div>
  </form>
</div>