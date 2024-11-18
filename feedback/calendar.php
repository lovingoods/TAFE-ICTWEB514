<?php include 'config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

  <!-- Popper.js and Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

  <!-- FullCalendar JS -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

  <title>Leave Feedback</title>
</head>
<style>
  .fc-event-title {
    font-size: 16px; /* 調整事件標題字體大小 */
  }
  .fc-daygrid-event {
    white-space: normal; /* 允許事件標題換行 */
  }
</style>
<body>
  <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4">
    <div class="container">
      <a class="navbar-brand" href="#">Traversy Media</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="feedback.php">Feedback</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="calendar.php">Schedule</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <div class="container d-flex flex-column align-items-center">
      <h2>Fitness Class Calendar</h2>
      <div id="calendar"></div>
    </div>
    <div class="modal" id="bookingModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Book Class Now</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="bookingFrom" action="booking.php" method="post">
              <input type="hidden" id="eventId" name="eventId">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Mobile</label>
                <input type="tel" id="phone" name="phone" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Ensure FullCalendar is available after the DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
      const calendarEl = document.getElementById('calendar');
      if (!calendarEl) return;

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'en',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 'fetch-events.php',
        eventColor: '#3788d8',
        dayMaxEventRows: false, // 顯示所有活動
        height: 'auto', // 根據內容自動調整高度
        aspectRatio: 1.5, // 寬高比例
        expandRows: true, // 自動填充空間

        eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false // 設為 false 表示使用 24 小時制
  },

        eventClick: function(info) {
            const event = info.event;
            document.getElementById('eventId').value = event.id;
            const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
            modal.show();
          }
        });

      calendar.render();
    });
  </script>

  <!-- Footer (optional) -->
  <footer class="bg-light text-center py-3">
    <p>&copy; 2024 Traversy Media</p>
  </footer>
</body>
</html>