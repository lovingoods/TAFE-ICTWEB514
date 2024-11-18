<?php include 'inc/header.php'; ?>


<?php
  $sql = 'SELECT * FROM feedback ORDER BY appointment_date';
  $result = mysqli_query($conn, $sql);
  $feedback = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<h2>Appointment List</h2>

<?php if (empty($feedback)): ?>
  <p class="lead mt3">No appointments found.</p>
<?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col">Class</th>
        <th scope="col">Trainer</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($feedback as $item): ?>
        <tr>
          <td><?php echo $item['name']; ?></td>
          <td><?php echo $item['email']; ?></td>
          <td><?php echo $item['appointment_date']; ?></td>
          <td><?php echo $item['appointment_time']; ?></td>
          <td><?php echo $item['body']; ?></td>
          <td><?php echo $item['trainer']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php include 'inc/footer.php'; ?>
