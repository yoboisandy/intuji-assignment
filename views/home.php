<?php
$googleClient = new Services\GoogleClient();
?>
<div>
  <div class="text-center">
    <h3>Google Calendar Events</h3>
  </div>
  <?php if (isset($_SESSION["access_token"])) : ?>
    <div>
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
          $events = $googleClient->getEvents('primary');
          foreach ($events as $event) {
          ?>
            <tr>
              <td><?= $event->summary ?></td>
              <td><?= $event->start->dateTime ?></td>
              <td><?= $event->end->dateTime ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php endif ?>
</div>